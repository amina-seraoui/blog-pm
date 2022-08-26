<?php

namespace App\DataFixtures;

use App\Entity\Option;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class OptionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
//        $options[] = new Option('Titre du blog', 'blog_title', 'Mon blog', TextType::class);
        $options[] = new Option('Copyright', 'blog_copyright', '© Pentinimax. Tous droits réservés.', TextType::class);
        $options[] = new Option('Nombre d\'articles par page', 'blog_page_articles_limit', 5, NumberType::class);
        $options[] = new Option('Nombre de commentaire par page', 'blog_page_comments_limit', 5, NumberType::class);
        $options[] = new Option('Peut-on s\'inscrire', 'users_can_register', true, CheckboxType::class);

        foreach ($options as $option) $manager->persist($option);

        $manager->flush();
    }
}
