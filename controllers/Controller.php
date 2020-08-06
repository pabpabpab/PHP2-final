<?php

namespace App\controllers;


use App\engine\App;
use App\services\Request;
use App\traits\MsgMaker;
use App\traits\Redirect;

abstract class Controller
{
    use MsgMaker;
    use Redirect;

    protected $action;
    protected $actionDefault = 'index';

    protected $app;
    protected $request;


    public function __construct(App $app, Request $request)
    {
        $this->app = $app;
        $this->request = $request;
    }

    public function run($action)
    {
        $this->action = $action;
        if (empty($this->action)) {
            $this->action = $this->actionDefault;
        }

        $method = $this->action . "Action";
        if (!method_exists($this, $method)) {
            $this->redirect('/page404');
            return false;
        }

        return $this->$method();
    }

    protected function getId()
    {
        return $this->request->getId();
    }

    protected function getPage()
    {
        return $this->request->getPage();
    }

    protected function getQuantityPerPage()
    {
        return $this->request->getQuantityPerPage();
    }

    protected function post($key)
    {
        return $this->request->post($key);
    }

    protected function session($key)
    {
        return $this->request->session($key);
    }

    protected function files($key)
    {
        return $this->request->files($key);
    }

    protected function getUserData()
    {
        return $this->session('user');
    }

    protected function isAdmin()
    {
        return $this->app->authService->isAdmin();
    }

    public function render($template, $params = [])
    {
        $params['msg'] = $this->getMSG();
        $params['cartCount'] = (int) $this->session('cartCount');
        $params['user'] = $this->getUserData();

        return $this->app->renderer->render($template, $params);
    }

    public function renderTemplate($template, $params = [])
    {
        return $this->app->renderer->render($template, $params);
    }
}
