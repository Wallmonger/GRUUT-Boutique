<?php

namespace App\Controller\Admin;

use App\Entity\MaterialsOfProduct;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use MaterialsOfProductType;

class MaterialsOfProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MaterialsOfProduct::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('product'),
            AssociationField::new('material'),
            IntegerField::new('quantity'),
    
            
        ];
    }
    
}
