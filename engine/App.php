<?php

namespace App\engine;

use App\repositories\GoodRepository;
use App\repositories\UserRepository;
use App\services\AuthService;
use App\services\DB;
use App\services\GoodService;
use App\services\Paginator;
use App\services\Request;
use App\services\TwigRendererServices;
use App\traits\MsgMaker;
use App\traits\Redirect;
use App\traits\TSingleton;

/**
 * Class App
 * @package App\engine
 *
 * @property Request $request
 * @property DB $db
 * @property TwigRendererServices $renderer
 * @property GoodRepository $goodRepository
 * @property UserRepository $userRepository
 * @property GoodService $goodService
 * @property AuthService $authService
 * @property PaginatorServices $paginatorServices
 */
class App
{
    use TSingleton;
    use MsgMaker;
    use Redirect;

    protected $config = [];
    /**
     * @var Container
     */
    protected $container;

    /**
     * @return App
     */
    public static function call()
    {
        return static::getInstance();
    }

    public function run($config)
    {
        $this->config = $config;
        $this->setContainer();
        return $this->runController();
    }

    protected function setContainer()
    {
        $this->container = new Container($this->config['components']);
    }

    protected function runController()
    {
        $request = $this->request;

        $controllerName = $request->getFullControllerName();
        if (class_exists($controllerName)) {
            /** @var \App\controllers\Controller $realController */
            $realController = new $controllerName(
                $this,
                $request
            );
            return $realController->run($request->getActionName());
        }

        $this->redirect('/page404');
        return '';
    }

    public function __get($name)
    {
        return $this->container->$name;
    }

    public function getConfig($key = '', $defaultValue = null)
    {
        if (empty($key)) {
            return $this->config;
        }

        if (!empty($this->config[$key])) {
            return $this->config[$key];
        }

        return $defaultValue;
    }

}
