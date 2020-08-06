<?php


namespace App\services;

use App\entities\User;

class AuthService extends Service
{
    public function login($data)
    {
        $data['email'] = strtolower(trim($data['email']));

        $error = $this->checkData($data);
        if (!empty($error)) {
            $this->setMSG($error);
            return false;
        }

        if (!$this->container->userRepository->isUserExists($data['email'])) {
            $this->setMSG('Неверно указан логин или пароль.');
            return false;
        }

        $user = $this->container->userRepository->getUserByLogin($data['email']);

        if (!password_verify($data['password'], $user->password)) {
            $this->setMSG('Неверно указан пароль или логин.');
            return false;
        }

        $this->setSession($user);

        return true;
    }

    protected function checkData($data)
    {
        $error = '';
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $error .= 'Неверно указан email.<br>';
        }
        if (empty($data['password'])) {
            $error .= 'Не указан пароль.<br>';
        }
        return $error;
    }

    protected function setSession(User $user)
    {
        $userData = [];
        $userData['authorized'] = true;
        $userData['id'] = $user->id;
        $userData['name'] = $user->name;
        $userData['is_admin'] = $user->is_admin;


        if ($user->is_admin) {
            $userData['number_of_orders'] = $this->container->orderRepository->getRowsCount();
            $userData['number_of_products'] = $this->container->goodRepository->getRowsCount();
        } else {
            $userData['number_of_orders'] = $user->number_of_orders;
            $userData['number_of_products'] = $user->number_of_products;
        }

        $this->container->request->setSession('user', $userData);
    }

    public function updateSessionUserData($key, $value)
    {
        $userData = $this->container->request->session('user');
        $userData[$key] = $value;
        $this->container->request->setSession('user', $userData);
        return;
    }

    public function isAdmin()
    {
        $userData = $this->container->request->session('user');
        if ($userData['is_admin'] == 1) {
            return true;
        }
        return false;
    }

    public function checkAuthorization()
    {
        $userData = $this->container->request->session('user');
        if (!$userData['authorized']) {
            $this->redirect('/auth');
            exit();
        }
        return true;
    }

    public function hasOrderPermission($orderId, $userData)
    {
        if ($userData['is_admin']) {
            return true;
        }

        $order = $this->container->orderRepository->getOne($orderId);
        if ($order->user_id === $userData['id']) {
            return true;
        }

        return false;
    }

    public function logout()
    {
        unset($_SESSION['user']);
        unset($_SESSION['usersCount']);
        return;
    }
}