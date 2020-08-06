<?php

namespace App\services;

use \App\engine\App;
use App\entities\Good;
use App\traits\DataValidator;

class GoodService extends Service
{
    use DataValidator;

    public function getOne($goodId)
    {
        $this->container->goodRepository->updateGoodByViewCountIncrement($goodId);
        return $this->container->goodRepository->getOneWithImages($goodId);
    }

    public function saveFromPost($goodId)
    {
        $data = $this->container->request->post('');
        $data['id'] = $goodId;
        $data['user_id'] = $this->container->request->session('user')['id'];

        $result = $this->saveCore($data);

        if (empty($result)) {
            $this->setMSG('Не удалось сохранить новые данные.');
            $this->redirect('/personal');
            exit();
        }

        $action = ($goodId > 0) ? 'update' : 'insert';
        if ($action == 'update') {
            $savedGoodId = $goodId;
        } else {
            $savedGoodId = $result;
            $this->container->userService->updateUserGoodsCount($data['user_id']);
        }

        $htmlFormImgFieldName = App::call()->getConfig('components')['filesUploader']['config']['htmlFormImgFieldName'];
        $uploaded = $this->container->request->files($htmlFormImgFieldName);

        if (!empty($uploaded['name'][0])) {
            $successImageCount = $this->saveUploadedImages($uploaded, $savedGoodId);
            if ($successImageCount === 0) {
                $this->setMSG('Ни одного фото не удалось сохранить.');
            }
        }

        return $savedGoodId; // int
    }

    public function saveCore($data)
    {
        if (!empty($data['id'])) {
            if (!$this->container->goodRepository->isExists($data['id'])) {
                $this->setMSG('Товар не существует.');
                $this->redirect('');
                exit();
            }
        }

        $error = $this->checkData($data);
        if (!empty($error)) {
            $this->setMSG($error);
            $this->redirect('');
            exit();
        }

        $good = new Good();

        $good->id = $data['id'];
        $good->user_id = $data['user_id'];
        $good->name = $data['name'];
        $good->info = $data['info'];
        $good->price = $data['price'];
        $good->modification_time = time();
        return $this->container->goodRepository->save($good);
    }

    protected function saveUploadedImages($uploaded, $goodId)
    {
        $prefix = $goodId;

        list($correctImages, $uploadErrors) = $this->container->filesUploader->multipleUpload($uploaded, $prefix);

        if (!empty($uploadErrors)) {
            $this->setMSG(implode("<br>", $uploadErrors));
        }

        if (empty($correctImages)) {
            return 0;
        }

        $imgFolder = App::call()->getConfig('components')['filesUploader']['config']['imgFolder'];

        list($successImageCount, $errors) = $this->insertImagesToDatabase($goodId, $correctImages, $imgFolder);

        if (!empty($errors)) {
            $this->setMSG(implode("<br>", $errors));
        }

        return $successImageCount;
    }

    protected function insertImagesToDatabase($goodId, $images, $imgFolder)
    {
        $errors = [];
        $insertErrorCount = 0;
        $successImages = [];

        foreach ($images as $imgName) {
            $result = $this->container->goodRepository->insertImage($goodId, $imgName);
            if (empty($result)) {
                $insertErrorCount++;
                continue;
            }
            $successImages[] = $imgName;
        }

        if ($insertErrorCount > 0) {
            $errors[] = 'Не удалось сохранить в базе ' . $insertErrorCount . ' фото.';
        }

        if (empty($successImages)) {
            return $errors;
        }

        $successImageCount = count($successImages);
        $mainImage = $successImages[0];
        $result = $this->container->goodRepository->updateGoodByImagesInfo($goodId, $imgFolder, $mainImage, $successImageCount);

        if ($result !== 1) {
            $errors[] = 'Не удалось сохранить в таблице товара данные о фото.';
            $successImageCount = 0;
        }

        return [$successImageCount, $errors];
    }

    protected function checkData($data)
    {
        $error = '';
        if (empty($data['name'])) {
            $error .= 'Не указано наименование товара.<br>';
        }
        if (empty($this->getNumeric($data['price']))) {
            $error .= 'Не указана цена товара.<br>';
        }
        if (empty($data['info'])) {
            $error .= 'Не указано описание товара.<br>';
        }
        return $error;
    }

    public function delete($goodId)
    {
        $good = $this->container->goodRepository->getOneWithImages($goodId);

        if ($good->number_of_images > 0) {
            $this->deleteImages($goodId, $good->images, $good->img_folder);
        }

        $result = $this->container->goodRepository->delete($goodId);

        if ($result == 1) {
            $userId = $this->container->request->session('user')['id'];
            $this->container->userService->updateUserGoodsCount($userId);
        }

        return $result;
    }

    public function deleteImages($goodId, $images, $imgFolder)
    {
        list($imageFiles, $missingFiles) = $this->getRealImgFiles($images, $imgFolder);
        if (count($missingFiles) > 0) {
            $this->setMSG('Не удалось найти файлы фото:<br>' . implode('<br>', $missingFiles) . '<br>Удаление отменено.');
            $this->redirect('/good/one?id=' . $goodId);
            exit();
        }

        $deleteError = [];
        foreach ($imageFiles as $imageFile) {
            if (!unlink($imageFile)) {
                $deleteError[] = "Не удалось удалить файл фото товара " . $imageFile;
            }
        }

        $deletedCount = $this->container->goodRepository->deleteImagesInfo($goodId);
        if ($deletedCount === 0) {
            $deleteError[] = "Ошибка удаления информации о фото товара из базы.";
        }

        if (!empty($deleteError)) {
            $this->setMSG(implode('<br>', $deleteError));
        }

        return $deletedCount;
    }

    protected function getRealImgFiles($images, $imgFolder)
    {
        $imgPath = App::call()->getConfig('components')['filesUploader']['config']['imgPath'];
        $existingFiles = [];
        $missingFiles = [];
        foreach ($images as $imgName) {
            $imageFile = $imgPath . '/' . $imgFolder . '/' . $imgName;
            if (!is_file($imageFile)) {
                $missingFiles[] = $imageFile;
                continue;
            }
            $existingFiles[] = $imageFile;
        }
        return [$existingFiles, $missingFiles];
    }
}