<?php


namespace App\entities;

class Good extends Entity
{
    public $id;
    public $user_id;
    public $name;
    public $price;
    public $info;
    public $img_folder = 0;
    public $main_img_name = '';
    public $images = [];
    public $number_of_images = 0;
    public $number_of_comments = 0;
    public $modification_time;

    public $inserted = [
        'user_id',
        'name',
        'price',
        'info',
        'modification_time'
    ];

    public function __set($name, $value) {}
}