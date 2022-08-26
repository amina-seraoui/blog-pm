<?php

namespace App\Controller;

use App\Controller\Model\WelcomeModel;
use App\Entity\Option;
use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Service\ArticleService;
use App\Service\OptionService;
use App\Type\WelcomeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ArticleService $articleService, CategoryRepository $categoryRep): Response
    {
        return $this->render('home/index.html.twig', [
            'articles' => $articleService->getPaginatedArticles(),
            'categories' => $categoryRep->findAll()
        ]);
    }

    #[Route('/welcome', name: 'welcome')]
    public function welcome(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher, OptionService $optionService): Response
    {
        // Si le site est déjà installé
        if ($optionService->getValue(WelcomeModel::INSTALLED_NAME)) {
            return $this->redirectToRoute('home');
        }

        // Sinon vérifier le formulaire
        $form = $this->createForm(WelcomeType::class, new WelcomeModel());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $title = new Option(WelcomeModel::TITLE_LABEL, WelcomeModel::TITLE_NAME, $data->getTitle(), TextType::class);
            $installed = new Option(WelcomeModel::INSTALLED_LABEL, WelcomeModel::INSTALLED_NAME, true, null);
            $admin = new User();
            $admin->setUsername($data->getUsername());
            $admin->setPassword($passwordHasher->hashPassword($admin, $data->getPassword()));
            $admin->setRoles(['ROLE_ADMIN']);

            $em->persist($title);
            $em->persist($installed);
            $em->persist($admin);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('home/welcome.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
