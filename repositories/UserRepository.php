<?php

namespace App\repositories;

use App\entities\User;

class UserRepository extends Repository
{
    public function getTableName(): string
    {
        return 'users';
    }

    public function getEntityName(): string
    {
        return User::class;
    }

    public function isUserExists($email)
    {
        $sql = "SELECT count(*) AS `count` FROM " . $this->getTableName() . ' WHERE login = :login';
        $result = $this->getDB()->find($sql, [':login' => $email]);
        if ($result['count'] != 1) {
            return false;
        }
        return true;
    }

    public function getUserByLogin($email)
    {
        $sql = 'SELECT * FROM ' . $this->getTableName() . ' WHERE login = :login';
        return $this->getDB()->findObject($sql, $this->getEntityName(), [':login' => $email]);
    }

    public function updateUserByNumberOfOrders($userId, $numberOfOrders)
    {
        $sql = 'UPDATE ' . $this->getTableName() . ' SET number_of_orders = :number_of_orders WHERE id = :user_id';

        $params = [
            ':number_of_orders' => $numberOfOrders,
            ':user_id' => $userId
        ];

        $pdoStatement = $this->getDB()->execute($sql, $params);
        return $pdoStatement->rowCount(); // number of affected rows
    }

    public function updateUserByNumberOfGoods($userId, $numberOfGoods)
    {
        $sql = 'UPDATE ' . $this->getTableName() . ' SET number_of_products = :number_of_products WHERE id = :user_id';

        $params = [
            ':number_of_products' => $numberOfGoods,
            ':user_id' => $userId
        ];

        $pdoStatement = $this->getDB()->execute($sql, $params);
        return $pdoStatement->rowCount(); // number of affected rows
    }
}
