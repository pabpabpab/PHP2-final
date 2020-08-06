<?php


namespace App\entities;


class Comment extends Entity
{
    public $id;
    public $product_id;
    public $text;

    public $inserted = [
        'product_id',
        'text'
    ];

    public function __set($name, $value) {}
}
