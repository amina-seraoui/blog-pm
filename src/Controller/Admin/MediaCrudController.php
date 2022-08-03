<?php

namespace App\Controller\Admin;

use App\Entity\Media;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MediaCrudController extends AbstractCrudController
{
    public function __construct(private string $mediasDir, private string $uploadsDir)
    {}

    public static function getEntityFqcn(): string
    {
        return Media::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $imageField = ImageField::new('filename', 'Média')
            ->setBasePath($this->uploadsDir)
            ->setUploadDir($this->mediasDir)
            ->setUploadedFileNamePattern('[slug]-[uuid].[extension]')
        ;

        if (Crud::PAGE_EDIT === $pageName)
        {
            $imageField->setRequired(false);
        }

        yield $imageField;
        yield TextField::new('name');
        yield TextField::new('alt');
    }
}
