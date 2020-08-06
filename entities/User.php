<?php


namespace App\entities;

class User extends Entity
{
    public $id;
    public $name;
    public $login;
    public $password;
    public $is_admin;
    public $number_of_products;
    public $number_of_orders;

    public $inserted = [
        'name',
        'login',
        'password'
    ];

    public function __set($name, $value) {}
}