<?php

namespace App\Controller\Admin;

use App\Entity\Menu;
use App\Repository\MenuRepository;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\RequestStack;

class MenuCrudController extends AbstractCrudController
{
    const MENU_PAGES = 0;
    const MENU_ARTICLES = 1;
    const MENU_LINKS = 2;
    const MENU_CATEGORIES = 3;

    public function __construct(private RequestStack $stack, private MenuRepository $repository)
    {}

    public static function getEntityFqcn(): string
    {
        return Menu::class;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $index = $this->getSubMenuIndex();

        return $this->repository->getIndexQueryBuilder($this->getFieldName($index));
    }

    public function configureCrud(Crud $crud): Crud
    {
        $index = $this->getSubMenuIndex();
        $label = 'un menu';
        $plural = match ($index) {
            self::MENU_ARTICLES => 'Articles',
            self::MENU_PAGES => 'Pages',
            self::MENU_LINKS => 'Liens personnalisés',
            self::MENU_CATEGORIES => 'Catégories',
        };
        return $crud
            ->setEntityLabelInSingular($label)
            ->setEntityLabelInPlural($plural)
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name');
        yield $this->getField($this->getSubMenuIndex())->setRequired(true);
        yield NumberField::new('menuOrder');
        yield BooleanField::new('isVisible');
        yield AssociationField::new('subMenus');
    }

    private function getFieldName(int $index)
    {
        return match ($index) {
            self::MENU_ARTICLES => 'article',
            self::MENU_PAGES => 'page',
            self::MENU_LINKS => 'link',
            self::MENU_CATEGORIES => 'category',
        };
    }

    private function getField(int $index)
    {
        $field = $this->getFieldName($index);

        return ($field === 'link') ? TextField::new($field) : AssociationField::new($field);
    }

    private function getSubMenuIndex(): int
    {
        return $this->stack->getMainRequest()->query->getInt('submenuIndex');
    }
}
