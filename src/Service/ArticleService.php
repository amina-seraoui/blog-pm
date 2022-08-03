<?php

namespace App\Service;

use App\Entity\Category;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class ArticleService
{
    public function __construct(
        private RequestStack $requestStack,
        private ArticleRepository $articleRep,
        private PaginatorInterface $paginator,
        private OptionService $optionService
    ) {}

    public function getPaginatedArticles(?Category $category = null)
    {
        $req = $this->requestStack->getMainRequest();
        $page = $req->query->getInt('p', 1);
        $query = $this->articleRep->findForPagination($category);
        $limit = $this->optionService->getValue('blog_page_articles_limit');

        return $this->paginator->paginate($query, $page, $limit);
    }
}
