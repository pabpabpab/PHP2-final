<?php


namespace App\tests\services;


use App\entities\User;
use App\services\RegistrationService;
use PHPUnit\Framework\TestCase;

class RegistrationServiceTest extends TestCase
{

    /**
     * @param $data
     * @param $expected
     *
     * @dataProvider getData
     */
    public function testCheckData(array $data, $expected)
    {
        $registrationServiceReflection = new \ReflectionClass(RegistrationService::class);
        $methodCheckData = $registrationServiceReflection->getMethod('checkData');
        $methodCheckData->setAccessible(true);
        $registrationService = new RegistrationService();
        $result = $methodCheckData->invoke($registrationService, $data);

        $this->assertEquals($expected, $result);
    }

    public function getData()
    {
        $data = [];

        $data[] = [
            [
                'name' =>  'Alex',
                'email' =>  '123@123.ru',
                'password' =>  '123123',
                'password2' =>  '123123'
            ],
            ''
        ];

        $data[] = [
            [
                'name' =>  '',
                'email' =>  '123@123.ru',
                'password' =>  '123123',
                'password2' =>  '123123'
            ],
            'Не указано имя.<br>'
        ];

        $data[] = [
            [
                'name' =>  'Vova',
                'email' =>  'fghfghfg',
                'password' =>  '123123',
                'password2' =>  '123123'
            ],
            'Неверно указан email.<br>'
        ];

        $data[] = [
            [
                'name' =>  'Alex',
                'email' =>  '123@123.ru',
                'password' =>  '123123',
                'password2' =>  ''
            ],
            'Не указано подтверждение пароля.<br>'
        ];

        $data[] = [
            [
                'name' =>  'Alex',
                'email' =>  '123@123.ru',
                'password' =>  '123123',
                'password2' =>  'xxxxxx'
            ],
            'Пароль подтвержден неверно.'
        ];

        return $data;
    }


    /**
     * @param $userMock
     * @param $expected
     *
     * @dataProvider getData2
     */
    public function testSendMail($userMock, $expected)
    {
        $registrationServiceReflection = new \ReflectionClass(RegistrationService::class);
        $methodSendMail = $registrationServiceReflection->getMethod('sendMail');
        $methodSendMail->setAccessible(true);
        $registrationService = new RegistrationService();

        $result = $methodSendMail->invoke($registrationService, $userMock);

        $this->assertEquals($expected, $result);
    }

    public function getData2()
    {
        $data = [];

        $userMock = $this->getMockBuilder(User::class)->getMock();
        $data[] = [$userMock, false];


        $userMock2 = $this->getMockBuilder(User::class)->getMock();
        $userMock2->login = '111@111.ru';
        $data[] = [$userMock2, true];

        return $data;
    }
}
