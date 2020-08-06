<?php


namespace App\controllers;


class AuthController extends Controller
{
    public function indexAction()
    {
        return $this->render('loginForm', []);
    }

    public function loginAction()
    {
        $result = $this->app->authService->login($this->post(''));

        if (!$result) {
            $this->redirect('/auth');
            return false;
        }

        $this->redirect('/personal');
        return true;
    }

    public function logoutAction()
    {
        $this->app->authService->logout();
        $this->redirect('/auth');
        return true;
    }
}