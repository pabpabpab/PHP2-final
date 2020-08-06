<?php

namespace App\tests\services;

use App\services\DB;
use PHPUnit\Framework\TestCase;

class DBTest extends TestCase
{

    /**
     * @param $config
     * @param $expectedDSN
     *
     * @dataProvider getData
     */
    public function testInvalidDBConfig(array $config, $expectedDSN)
    {
        $dbReflection = new \ReflectionClass(DB::class);
        $methodGetPrepareDsnString = $dbReflection->getMethod('getPrepareDsnString');
        $methodGetPrepareDsnString->setAccessible(true);
        $db = new DB($config);
        $result = $methodGetPrepareDsnString->invoke($db);

        $this->assertEquals($expectedDSN, $result);
    }

    public function getData()
    {
        $data = [];

        $data[] = [
            [
                'driver' =>  'mysql',
                'host' =>  'localhost',
                'dbname' =>  'gbshop',
                'charset' =>  'UTF8',
                'user' => 'root',
                'password' => 'root'
            ],
            "mysql:host=localhost;dbname=gbshop;charset=UTF8"
        ];

        $data[] = [
            [
                'driver' =>  'mysql',
                'host' =>  '127.0.0.1',
                'dbname' =>  'gbshop',
                'charset' =>  'UTF8',
                'user' => 'root',
                'password' => 'root'
            ],
            "mysql:host=127.0.0.1;dbname=gbshop;charset=UTF8"
        ];

        $data[] = [
            [
                'driver' =>  'mysql',
                'host' =>  'localhost',
                'dbname' =>  'gbphp',
                'charset' =>  'CP1251',
                'user' => 'root',
                'password' => 'root'
            ],
            "mysql:host=localhost;dbname=gbphp;charset=CP1251"
        ];

        return $data;
    }
}
