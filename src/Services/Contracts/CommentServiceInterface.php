<?php
/**
 * Created by PhpStorm.
 * User: Andrey Dubinin
 * Date: 11.08.2019
 * Time: 15:47
 */

namespace App\Services\Contracts;


use App\Entity\Comment;
use Symfony\Component\HttpFoundation\Request;

interface CommentServiceInterface
{
    public function saveForm(Request $request, Comment $comment): Comment;
}