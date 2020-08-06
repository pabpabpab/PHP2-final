<?php


namespace App\controllers;


class IndexController extends Controller
{
    public function indexAction()
    {
        return $this->render(
            'index',
            []
        );
    }
}