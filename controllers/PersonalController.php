<?php


namespace App\controllers;


class PersonalController extends Controller
{
    public function indexAction()
    {
        $this->checkAuthorization();

        $content = $this->renderTemplate('personal_index', []);

        return $this->personalRender($content);
    }

    public function usersAction()
    {
        if (!$this->isAdmin()) {
            $this->redirect('');
            return false;
        }

        $params = [
            'entityName' => 'user',
            'baseUrl' => '/personal/users',
            'quantityPerPage' => $this->getQuantityPerPage(),
            'pageNumber' => $this->getPage()
        ];

        $paginator = $this->app->paginator;
        $paginator->setItems($params);

        $content = $this->renderTemplate(
            'personal_users',
            [
                'paginator' => $paginator
            ]
        );

        return $this->personalRender($content);
    }

    public function ordersAction()
    {
        $this->checkAuthorization();

        $userId = $this->getUserData()['id'];
        if ($this->isAdmin()) {
            $userId = 0;
        }

        $params = [
            'entityName' => 'order',
            'baseUrl' => '/personal/orders',
            'quantityPerPage' => $this->getQuantityPerPage(),
            'pageNumber' => $this->getPage(),
            'userId' => $userId
        ];

        $paginator = $this->app->paginator;
        $paginator->setItems($params);

        $content = $this->renderTemplate(
            'personal_orders',
            [
                'paginator' => $paginator,
                'isAdmin' => $this->isAdmin(),
                'statuses' => $this->app->orderRepository->getOrderStatuses(),
            ]
        );

        return $this->personalRender($content);
    }

    public function orderAction()
    {
        $this->checkAuthorization();

        $id = $this->getId();

        if (!$this->app->orderRepository->isExists($id)) {
            $this->setMSG('Заказ с id ' . $id . ' не существует.');
            $this->redirect('/page404');
            return false;
        }

        $userData = $this->getUserData();
        if (!$this->app->authService->hasOrderPermission($id, $userData)) {
            $this->redirect('');
            return false;
        }

        $order = $this->app->orderService->getOne($id);

        $content = $this->renderTemplate(
            'personal_order',
            [
               'order' => $order,
               'isAdmin' => $this->isAdmin(),
               'statuses' => $this->app->orderRepository->getOrderStatuses(),
               'imgPath' => $this->app->getConfig('imgPath')
            ]
        );

        return $this->personalRender($content);
    }

    public function changeOrderStatusAction()
    {
        if (!$this->isAdmin()) {
            $this->redirect('');
            return false;
        }

        $id = $this->getId();

        if (!$this->app->orderRepository->isExists($id)) {
            $this->setMSG('Заказ с id ' . $id . ' не существует.');
            $this->redirect('/page404');
            return false;
        }

        if (!$this->app->orderService->changeStatus($id, $this->post('status'))) {
            $this->setMSG('Не удалось поменять статус заказа.');
            $this->redirect('');
            return false;
        }

        $this->redirect('/personal/order?id=' . $id);
        return true;
    }

    public function goodsAction()
    {
        $params = [
            'entityName' => 'good',
            'baseUrl' => '/personal/goods',
            'quantityPerPage' => $this->getQuantityPerPage(),
            'pageNumber' => $this->getPage()
        ];

        $paginator = $this->app->paginator;
        $paginator->setItems($params);

        $content = $this->renderTemplate(
            'personal_goods',
            [
                'paginator' => $paginator,
                'imgPath' => $this->app->getConfig('imgPath')
            ]
        );

        return $this->personalRender($content);
    }

    public function addGoodAction()
    {
        $this->checkAuthorization();

        $content = $this->renderTemplate(
            'addGood',
            []
        );

        return $this->personalRender($content);
    }

    public function editGoodAction()
    {
        $this->checkAuthorization();

        $id = $this->getId();

        $content = $this->renderTemplate(
            'addGood',
            [
                'good' => $this->app->goodRepository->getOne($id),
            ]
        );

        return $this->personalRender($content);
    }

    public function saveGoodAction()
    {
        if (!$this->isAdmin()) {
            $this->redirect('/personal');
            return 0;
        }

        $goodId = $this->getId();

        $savedGoodId = $this->app->goodService->saveFromPost($goodId);

        if (empty($savedGoodId)) {
            $this->redirect('/personal');
            return 0;
        }

        $this->redirect('/good/one?id=' . $savedGoodId);
        return 1; // int
    }

    public function deleteGoodAction()
    {
        if (!$this->isAdmin()) {
            $this->redirect('/personal');
            return 0;
        }

        $goodId = $this->getId();
        if (!($this->app->goodRepository->isExists($goodId))) {
            $this->setMSG('Товар не существует.');
            $this->redirect('');
            return false;
        }

        $result = $this->app->goodService->delete($goodId);

        if ($result !== 1) {
            $this->setMSG('Не удалось удалить товар.');
            $this->redirect('');
            return false;
        }

        $this->setMSG('Товар номер ' . $goodId . ' удален.');
        $this->redirect('/personal/goods');
        return true;
    }

    protected function personalRender($content)
    {
        return $this->render('personal_page_wrapper', [
            'personalMenu' => $this->getPersonalMenu(),
            'personalContent' => $content
        ]);
    }

    protected function getPersonalMenu()
    {
        $user = $this->getUserData();

        $usersCount = 0;
        if ($this->isAdmin()) {
            $usersCount = $this->app->userService->getUsersCount();
        }

        return $this->renderTemplate(
            'personalMenu',
            [
                'user' => $user,
                'usersCount' => $usersCount
            ]
        );
    }

    protected function checkAuthorization()
    {
        return $this->app->authService->checkAuthorization();
    }
}