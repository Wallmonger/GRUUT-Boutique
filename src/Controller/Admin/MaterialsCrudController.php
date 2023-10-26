<?php

namespace App\Controller\Admin;

use App\Entity\Materials;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MaterialsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Materials::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
