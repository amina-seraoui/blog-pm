<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    #[Route('/{slug}', name: 'page_show', priority: -10)]
    public function show(): Response
    {
        return $this->render('page/show.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }
}
