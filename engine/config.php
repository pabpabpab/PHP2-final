<?php

//'imgPath' => 'http://' . $_SERVER['SERVER_NAME'],

return [
    'name' => 'Интернет Магазин',
    'defaultController' => 'good',
    'imgPath' => '..',

    'components' => [
        'db' => [
            'class' => \App\services\DB::class,
            'config' => [
                'driver' =>  'mysql',
                'host' =>  'localhost',
                'dbname' =>  'gbshop',
                'charset' =>  'UTF8',
                'user' => 'root',
                'password' => 'root'
            ]
        ],
        'request' => [
            'class' => \App\services\Request::class,
        ],
        'renderer' => [
            'class' => \App\services\TwigRendererServices::class,
        ],
        'goodRepository' => [
            'class' => \App\repositories\GoodRepository::class,
        ],
        'commentRepository' => [
            'class' => \App\repositories\CommentRepository::class,
        ],
        'orderRepository' => [
            'class' => \App\repositories\OrderRepository::class,
        ],
        'userRepository' => [
            'class' => \App\repositories\UserRepository::class,
        ],
        'userService' => [
            'class' => \App\services\UserService::class,
        ],
        'goodService' => [
            'class' => \App\services\GoodService::class,
        ],
        'commentService' => [
            'class' => \App\services\CommentService::class,
        ],
        'filesUploader' => [
            'class' => \App\services\FilesUploader::class,
            'config' => [
                'htmlFormImgFieldName' => 'userfile',
                'imgFolder' => 1,
                'imgPath' => '.',
                'maxImgWeightInMb' => 10
            ]
        ],
        'paginator' => [
            'class' => \App\services\Paginator::class,
        ],
        'registrationService' => [
            'class' => \App\services\RegistrationService::class,
        ],
        'authService' => [
            'class' => \App\services\AuthService::class,
        ],
        'cart' => [
            'class' => \App\services\Cart::class,
        ],
        'orderService' => [
            'class' => \App\services\OrderService::class,
        ],
    ],
];