<?php


namespace App\controllers;


class CartController extends Controller
{
    public function indexAction()
    {
        return $this->render(
            'cart',
            [
                'cart' => $this->app->cart->init(),
                'imgPath' => $this->app->getConfig('imgPath')
            ]
        );
    }

    public function addAction()
    {
        $id = $this->getId();
        $result = $this->app->cart->add($id);
        if (!$result) {
            $this->setMSG('Товар не добавился в корзину.');
        }
        $this->redirect('/cart');
        return 0;
    }

    public function deleteAction()
    {
        $id = $this->getId();
        $result = $this->app->cart->delete($id);
        if (!$result) {
            $this->setMSG('Ошибка удаления товара из корзины.');
        }
        $this->redirect('/cart');
        return 0;
    }

    public function saveAction()
    {
        $cart = $this->app->cart->init();

        $result = $cart->save($this->post('goodsCount'));
        if (!$result) {
            $this->setMSG('Изменения не сохранены.');
        }

        if (!empty($this->post('makeOrder'))) {
            $this->app->authService->checkAuthorization();
            $userId = $this->request->session('user')['id'];
            $orderId = $this->app->orderService->save($cart, $userId);
            if ($orderId > 0) {
                $this->redirect('/personal/order?id=' . $orderId);
                return;
            }
            $this->setMSG('Не удалось создать заказ.');
        }

        $this->redirect('/cart');
        return;
    }
}

