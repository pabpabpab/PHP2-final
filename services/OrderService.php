<?php


namespace App\services;

use App\entities\Order;

class OrderService extends Service
{

    public function save(Cart $cart, $userId)
    {
        if (empty($userId)) {
            return 0;
        }
        if (empty($cart->count)) {
            return 0;
        }

        $order = new Order();

        $order->id = 0;
        $order->user_id = $userId;
        $order->items = json_encode($cart->goods, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
        $order->total_price = $cart->totalPrice;
        $order->status = 1;

        $orderId = $this->container->orderRepository->save($order);

        if (empty($orderId)) {
            return 0;
        }

        $this->container->userService->updateUserOrdersCount($userId);

        $this->container->cart->resetCart();

        return $orderId;
    }

    public function getOne($id)
    {
        $order = $this->container->orderRepository->getOne($id);
        $order->itemsSet = json_decode($order->items, true, 512, JSON_INVALID_UTF8_IGNORE);
        return $order;
    }

    public function changeStatus($id, $status)
    {
        $statuses = $this->container->orderRepository->getOrderStatuses();
        if (!array_key_exists($status, $statuses)) {
            return false;
        }

        $result = $this->container->orderRepository->updateOrderByStatus($id, (int) $status);
        if ($result !== 1) {
            return false;
        }

        return true;
    }
}