<?php


namespace App\controllers;


class CommentController extends Controller
{
    public function indexAction()
    {
        $this->redirect('');
        return;
    }


    public function addAction()
    {
        $id = $this->getId();

        if (!($this->app->goodRepository->isExists($id))) {
            $this->setMSG('Товар не существует.');
            $this->redirect('');
            return false;
        }

        $result = $this->app->commentService->save($this->post(''), $id);

        if (!$result) {
            $this->setMSG('Не удалось добавить комментарий.');
        }

        $this->redirect('/good/one?id=' . $id);
        return true;
    }
}