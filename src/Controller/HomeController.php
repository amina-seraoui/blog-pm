<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ArticleRepository $articleRep, CategoryRepository $categoryRep): Response
    {
        return $this->render('home/index.html.twig', [
            'articles' => $articleRep->findAll(),
            'categories' => $categoryRep->findAll()
        ]);
    }
}
