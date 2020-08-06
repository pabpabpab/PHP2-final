<?php


namespace App\controllers;


class RegistrationController extends Controller
{
    public function indexAction()
    {
        return $this->render('registrationForm', []);
    }

    public function saveAction()
    {
        $userId = $this->app->registrationService->save($this->post(''));

        if ($userId === 0) {
            $this->setMSG('Регистрация не удалась.');
            $this->redirect('/registration');
            return 0;
        }


        $this->setMSG('Пользователь номер ' . $userId . ' удался.');

        $this->redirect('/personal');

        return $userId;
    }
}