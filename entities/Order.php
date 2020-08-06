<?php


namespace App\entities;


class Order extends Entity
{
    public $id;
    public $user_id;
    public $items;
    public $itemsSet = [];
    public $total_price;
    public $status;

    public $inserted = [
        'user_id',
        'items',
        'total_price',
        'status'
    ];

    public function __set($name, $value) {}
}