<?php

namespace App\Twig;

use App\Entity\Menu;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
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

    public function getFilters()
    {
        yield new TwigFilter('menuLink', [$this, 'menuLink']);
    }

    public function getFunctions()
    {
        yield new TwigFunction('admin_url', [$this, 'getAdminUrl']);
    }

    public function getAdminUrl(string $controller, string $action = 'index'): string
    {
        return $this->adminUrlGenerator
            ->setController(self::ADMIN_NAMESPACE . DIRECTORY_SEPARATOR . $controller)
            ->setAction($action)
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
