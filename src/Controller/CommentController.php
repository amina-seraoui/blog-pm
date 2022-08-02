<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    #[Route('/comments/add', name: 'comment_add')]
    public function add(
        Request $request,
        ArticleRepository $articleRep,
        UserRepository $userRep,
        CommentRepository $commentRep,
        EntityManagerInterface $em
    ): Response {
        $data = $request->request->all('comment');

        if (!$this->isCsrfTokenValid('comment-add', $data['_token'] ?? '')) {
            return $this->json(['code' => 'INVALID_CSRF_TOKEN'], Response::HTTP_UNAUTHORIZED);
        }

        $article = $articleRep->findOneBy(['id' => $data['article']]);


        if (!$article) {
            return $this->json(['code' => 'INVALID_ARTICLE'], Response::HTTP_BAD_REQUEST);
        }

        $user = $userRep->findOneBy(['id' => 1]);

        $comment = new Comment($article);
        $comment->setContent($data['content']);
        $comment->setUser($user);

        $em->persist($comment);
        $em->flush();

        $msg = $this->renderView('comment/_item.html.twig', [
            'comment' => $comment
        ]);

        return $this->json([
            'code' => 'COMMENT_ADDED_SUCCESFULLY',
            'msg' => $msg,
            'count' => $commentRep->count(['article' => $article->getId()])
        ]);
    }
}
