<?php


namespace App\services;

use App\entities\User;

class RegistrationService extends Service
{

    public function save($data)
    {
        $error = $this->checkData($data);
        if (!empty($error)) {
            $this->setMSG($error);
            $this->redirect('/registration');
            exit();
        }

        $data['email'] = strtolower(trim($data['email']));

        if ($this->container->userRepository->isUserExists($data['email'])) {
            $this->setMSG('Пользователь с логином ' . $data['email'] . ' уже существует. Регистрация отменена.');
            $this->redirect('/registration');
            exit();
        }

        $user = $this->createUserEntity($data);

        $user->id = $this->container->userRepository->save($user);

        if ($user->id === 0) {
            return 0;
        }

        $this->setSession($user);

        $this->sendMail($user);

        return $user->id;
    }

    protected function createUserEntity($data)
    {
        $hashPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        if ($hashPassword === false) {
            $this->setMSG('Не удалось обработать пароль.');
            $this->redirect('/registration');
            exit();
        }

        $user = new User();
        $user->id = 0;
        $user->name = $data['name'];
        $user->login = $data['email'];
        $user->password = $hashPassword;

        return $user;
    }

    protected function checkData($data)
    {
        $error = '';

        if (empty($data['name'])) {
            $error .= 'Не указано имя.<br>';
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $error .= 'Неверно указан email.<br>';
        }
        if (empty($data['password'])) {
            $error .= 'Не указан пароль.<br>';
        }
        if (empty($data['password2'])) {
            $error .= 'Не указано подтверждение пароля.<br>';
        }

        if (!empty($error)) {
            return $error;
        }

        if ($data['password'] != $data['password2']) {
            return 'Пароль подтвержден неверно.';
        }

        return '';
    }

    protected function setSession(User $user)
    {
        $userData = [];
        $userData['authorized'] = true;
        $userData['id'] = $user->id;
        $userData['name'] = $user->name;
        $userData['is_admin'] = 0;
        $userData['number_of_products'] = 0;
        $userData['number_of_orders'] = 0;

        $this->container->request->setSession('user', $userData);
    }

    protected function sendMail(User $user)
    {
        // Пока так
        $subject = 'Регистрация на сайте ' . $_SERVER['SERVER_NAME'];
        $message = 'На ваш e-mail создана регистрация на сайте ' . $_SERVER['SERVER_NAME'];
        if (!empty($user->login)) {
            return mail($user->login, $subject, $message);
        }
        return false;
    }
}