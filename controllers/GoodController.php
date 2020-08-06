<?php

namespace App\controllers;


class GoodController extends Controller
{
    public function indexAction()
    {
        return $this->allAction();
    }

    public function allAction()
    {
        $params = [
            'entityName' => 'good',
            'baseUrl' => '/good/all',
            'quantityPerPage' => $this->getQuantityPerPage(),
            'pageNumber' => $this->getPage()
        ];

        $paginator = $this->app->paginator;
        $paginator->setItems($params);

        return $this->render(
            'goods',
            [
                'paginator' => $paginator,
                'imgPath' => $this->app->getConfig('imgPath'),
                'cart' => $this->app->cart->init()
            ]
        );
    }

    public function oneAction()
    {
        $id = $this->getId();

        if (!$this->app->goodRepository->isExists($id)) {
            $this->setMSG('Товар с id ' . $id . ' не существует.');
            $this->redirect('/page404');
            return false;
        }

        return $this->render(
            'good',
            [
                'good' => $this->app->goodService->getOne($id),
                'imgPath' => $this->app->getConfig('imgPath'),
                'goodCartCount' => (int) $this->session('goods')[$id]['count'],
                'comments' => $this->app->commentRepository->getAllByGoodId($id)
            ]
        );
    }
}
