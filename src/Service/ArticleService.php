<?php

namespace App\Service;

use App\Entity\Category;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class ArticleService
{
    const LIMIT = 2;

    public function __construct(
        private RequestStack $requestStack,
        private ArticleRepository $articleRep,
        private PaginatorInterface $paginator
    ) {}

    public function getPaginatedArticles(?Category $category = null)
    {
        $req = $this->requestStack->getMainRequest();
        $page = $req->query->getInt('p', 1);
        $query = $this->articleRep->findForPagination($category);

        return $this->paginator->paginate($query, $page, self::LIMIT);
    }
}
