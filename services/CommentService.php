<?php


namespace App\services;

use App\entities\Comment;

class CommentService extends Service
{
    public function save($data, $goodId)
    {
        $error = $this->checkData($data);
        if (!empty($error)) {
            $this->setMSG($error);
            $this->redirect('');
            exit();
        }

        $comment = new Comment();
        $comment->id = (int) $data['id'];
        $comment->product_id = $goodId;
        $comment->text = $data['comment'];
        $result =  $this->container->commentRepository->save($comment);

        if ($result) {
            $this->container->goodRepository->updateGoodByCommentsCountIncrement($goodId);
        }
        return $result;
    }

    protected function checkData($data)
    {
        $error = '';
        if (empty($data['comment'])) {
            $error .= 'Не указан текст комментария.<br>';
        }
        return $error;
    }
}