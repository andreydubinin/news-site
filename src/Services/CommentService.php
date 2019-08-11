<?php
/**
 * Created by PhpStorm.
 * User: Andrey Dubinin
 * Date: 11.08.2019
 * Time: 15:39
 */

namespace App\Services;


use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\Contracts\CommentRepositoryInterface;
use App\Services\Contracts\CommentServiceInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class CommentService implements CommentServiceInterface
{
    /** @var CommentRepositoryInterface $commentRepository */
    private $commentRepository;

    /** @var ContainerInterface */
    protected $container;

    public function __construct(CommentRepositoryInterface $commentRepository, ContainerInterface $container)
    {
        $this->commentRepository = $commentRepository;
        $this->container = $container;
    }

    /**
     * @param Request $request
     * @param Comment $comment
     * @return Comment
     */
    public function saveForm(Request $request, Comment $comment): Comment
    {
        $form = $this->container->get('form.factory')->create(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commentRepository->save($comment);
        }

        return $comment;
    }
}