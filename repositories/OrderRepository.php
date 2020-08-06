<?php


namespace App\repositories;

use App\entities\Order;

class OrderRepository extends Repository
{
    public function getTableName(): string
    {
        return 'orders';
    }

    public function getEntityName(): string
    {
        return Order::class;
    }

    public function getOrderStatuses()
    {
        return [
            1 => 'Заказан',
            2 => 'Оплачен',
            3 => 'Доставлен'
        ];
    }

    public function updateOrderByStatus($id, $status)
    {
        $sql = 'UPDATE ' . $this->getTableName() . ' SET status = :status WHERE id = :id';

        $params = [
            ':status' => $status,
            ':id' => $id
        ];

        $pdoStatement = $this->getDB()->execute($sql, $params);
        return $pdoStatement->rowCount(); // number of affected rows
    }
}
