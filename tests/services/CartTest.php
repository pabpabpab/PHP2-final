<?php

namespace App\tests\services;

use App\services\Cart;
use PHPUnit\Framework\TestCase;

class CartTest extends TestCase
{
    public function testDeleteEmptyId()
    {
        $cart = new Cart();
        $result = $cart->delete(0);
        $this->assertFalse($result);
    }
}