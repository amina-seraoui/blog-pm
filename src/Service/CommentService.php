<?php

namespace App\Service;

use App\Entity\Article;
use App\Repository\CommentRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class CommentService
{
    const LIMIT = 5;

    public function __construct(
        private RequestStack $requestStack,
        private CommentRepository $commentRep,
        private PaginatorInterface $paginator
    ) {}

    public function getPaginatedComment(?Article $article = null)
    {
        $req = $this->requestStack->getMainRequest();
        $page = $req->query->getInt('p', 1);
        $query = $this->commentRep->findForPagination($article);

        return $this->paginator->paginate($query, $page, self::LIMIT);
    }
}
