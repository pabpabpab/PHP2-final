<?php


namespace App\engine;

use App\repositories\GoodRepository;
use App\repositories\UserRepository;
use App\services\DB;

/**
 * Class Container
 * @package App\engine
 *
 * @property DB $db
 * @property GoodRepository $goodRepository
 * @property UserRepository $userRepository
 */
class Container
{
    protected $components = [];
    protected $componentsItems = [];

    /**
     * Container constructor.
     * @param array $components
     */
    public function __construct(array $components)
    {
        $this->components = $components;
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->componentsItems)) {
            return $this->componentsItems[$name];
        }

        if (empty($this->components[$name])) {
            return null;
        }

        $class = $this->components[$name]['class'];
        if (!class_exists($class)) {
            return null;
        }

        if (array_key_exists('config', $this->components[$name])) {
            $config = $this->components[$name]['config'];
            $this->componentsItems[$name] = new $class($config);
        } else {
            $this->componentsItems[$name] = new $class();
        }

        if (method_exists($this->componentsItems[$name], 'setContainer')) {
            $this->componentsItems[$name]->setContainer($this);
        }

        return $this->componentsItems[$name];
    }
}