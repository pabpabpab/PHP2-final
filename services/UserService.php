<?php


namespace App\services;


class UserService extends Service
{

    public function getUsersCount()
    {
        $sessionUsersCount = $this->container->request->session('usersCount');
        if (empty($sessionUsersCount)) {
            $usersCount = $this->container->userRepository->getRowsCount();
            $this->container->request->setSession('usersCount', $usersCount);
            return $usersCount;
        }
        return $sessionUsersCount;
    }

    public function updateUserGoodsCount($userId)
    {
        if ($this->container->authService->isAdmin()) {
            $numberOfGoods = $this->container->goodRepository->getRowsCount();
        } else {
            $numberOfGoods = $this->container->goodRepository->getRowsCountByUserId($userId);
        }

        $this->container->userRepository->updateUserByNumberOfGoods($userId, $numberOfGoods);
        $this->container->authService->updateSessionUserData('number_of_products', $numberOfGoods);

        return;
    }

    public function updateUserOrdersCount($userId)
    {
        if ($this->container->authService->isAdmin()) {
            $numberOfOrders = $this->getUserOrdersCount();
        } else {
            $numberOfOrders = $this->getUserOrdersCount($userId);
            $this->updateUserByNumberOfOrders($userId, $numberOfOrders);
        }

        $this->container->authService->updateSessionUserData('number_of_orders', $numberOfOrders);

        return;
    }

    public function getUserOrdersCount($userId = 0)
    {
        if ($userId > 0) {
            return $this->container->orderRepository->getRowsCountByUserId($userId);
        }
        return $this->container->orderRepository->getRowsCount();
    }

    public function updateUserByNumberOfOrders($userId, $numberOfOrders)
    {
        return $this->container->userRepository->updateUserByNumberOfOrders($userId, $numberOfOrders);
    }
}