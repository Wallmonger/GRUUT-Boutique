<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;


class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

  
    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            SlugField::new('slug')->setTargetFieldName('name'),          # on reprend le nom du produit pour générer un slug (bonnet_de_cuir)
            ImageField::new('illustration')
                ->setBasePath('assets/img/uploads/')
                ->setUploadDir('public/assets/img/uploads')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            ChoiceField::new('style')->setChoices([
                    'Moderne' => 'Moderne',
                    'Traditionnel' => 'Traditionnel',
                    'Unique' => 'Unique',
                ]),
            ChoiceField::new('color')->setChoices([
                    'DarkBrown' => 'DarkBrown',    
                    'Brown' => 'Brown',
                    'Orange' => 'Orange',
                    'LightOrange' => 'LightOrange',
                    'Grey' => 'Grey',
                ]),
            TextField::new('subtitle'),
            TextareaField::new('description'),
            BooleanField::new('isBest'),
            MoneyField::new('price')->setCurrency('EUR'),
            AssociationField::new('category'),
            ArrayField::new('MaterialsOfProducts'),
            // CollectionField::new('materials')->setEntryIsComplex(),
            
            
        ];
    }
    
}
