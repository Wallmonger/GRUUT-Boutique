<?php

namespace App\Controller\Admin;

use App\Entity\AuthorizationAvis;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AuthorizationAvisCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AuthorizationAvis::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('user'),
            AssociationField::new('product'),
            BooleanField::new('isAllowed'),
        ];
    }
    
}
