<?php


namespace App\controllers;


class Page404Controller extends Controller
{
    public function indexAction()
    {
        $text = $this->getMSG();
        if (empty($text)) {
            $text = 'Страница не существует.';
        }
        return $this->render(
            'page404',
            [
                'text404' => $text
            ]
        );
    }
}