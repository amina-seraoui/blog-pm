<?php

namespace App\Twig;

use App\Entity\Menu;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    const ADMIN_NAMESPACE = 'App\Controller\Admin';

    public function __construct(private RouterInterface $router, private AdminUrlGenerator $adminUrlGenerator)
    {}

    public function getFilters(): array
    {
        return [
            new TwigFilter('menuLink', [$this, 'menuLink']),
        ];
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('ea_index', [$this, 'getAdminUrl'])
        ];
    }

    public function getAdminUrl(string $controller): string
    {
        return $this->adminUrlGenerator
            ->setController(self::ADMIN_NAMESPACE . DIRECTORY_SEPARATOR . $controller)
            ->generateUrl()
        ;
    }

    public function menuLink(Menu $menu): string
    {
        $url = $menu->getLink() ?? null;
        if ($url) return $url;

        if ($article = $menu->getArticle()) {
            $name = 'article_show';
            $slug = $article->getSlug();
        }

        if ($category = $menu->getCategory()) {
            $name = 'category_show';
            $slug = $category->getSlug();
        }

        if ($page = $menu->getPage()) {
            $name = 'page_show';
            $slug = $page->getSlug();
        }

        if (!isset($name, $slug)) return '#';

        return $this->router->generate($name, ['slug' => $slug]);
    }
}
