<?php
/**
 * Created by PhpStorm.
 * User: Andrey Dubinin
 * Date: 11.08.2019
 * Time: 15:41
 */

namespace App\Repository\Contracts;


use App\Entity\Comment;

interface CommentRepositoryInterface
{
    public function save(Comment $comment): void;
}