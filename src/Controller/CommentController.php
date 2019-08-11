<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Services\Contracts\CommentServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    /** @var CommentServiceInterface $commentService */
    private $commentService;

    public function __construct(CommentServiceInterface $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/comment", name="comment", methods={"GET"})
     */
    public function index()
    {
        return $this->render('comment/index.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/comment", name="comment.store", methods={"POST"})
     */
    public function store(Request $request)
    {
        $comment = new Comment();
        $this->commentService->saveForm($request, $comment);

        if ($request->request->has('referer')) {
            return $this->redirect($request->request->get('referer'));
        }
        return $this->redirectToRoute('homepage');
    }
}
