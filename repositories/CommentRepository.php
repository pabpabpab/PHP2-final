<?php


namespace App\repositories;

use App\entities\Comment;

class CommentRepository extends Repository
{

    public function getTableName(): string
    {
        return 'products_comments';
    }

    public function getEntityName(): string
    {
        return Comment::class;
    }

    public function getAllByGoodId($goodId)
    {
        $sql = 'SELECT * FROM ' . $this->getTableName() . ' WHERE product_id = :product_id';
        return $this->getDB()->findObjects($sql, $this->getEntityName(), [':product_id' => $goodId]);
    }
}