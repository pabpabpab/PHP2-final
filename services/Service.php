<?php

namespace App\services;

use App\engine\Container;
use App\traits\MsgMaker;
use App\traits\Redirect;

abstract class Service
{
    use MsgMaker;
    use Redirect;

    /**
     * @var Container
     */
    protected $container;

    public function setContainer(Container $container)
    {
        $this->container = $container;
    }
}