<?php

namespace App\Controller\Admin;

use App\Entity\AuthorizationAvis;
use App\Entity\Carrier;
use App\Entity\Category;
use App\Entity\Comments;
use App\Entity\Header;
use App\Entity\Materials;
use App\Entity\MaterialsOfProduct;
use App\Entity\Product;
use App\Entity\User;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return $this->render('@EasyAdmin/page/content.html.twig');

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        
        
       $materials = $this->entityManager->getRepository(Materials::class)->findAll();
       
        return $this->render('admin/admin.html.twig', [
            'materials' => $materials
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('GRUUT');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('État des stocks', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateur', 'fa fa-user', User::class);
        yield MenuItem::linkToCrud('Commandes', 'fa fa-shopping-cart', Order::class );
        yield MenuItem::linkToCrud('Categories', 'fa fa-list', Category::class);
        yield MenuItem::linkToCrud('Produits', 'fa fa-gift', Product::class);
        yield MenuItem::linkToCrud('Matériaux', 'fa fa-recycle', Materials::class);
        yield MenuItem::linkToCrud('Matériaux des produits', 'fa fa-gears', MaterialsOfProduct::class);
        yield MenuItem::linkToCrud('Transporteur', 'fa fa-truck', Carrier::class);
        yield MenuItem::linkToCrud('Headers', 'fa fa-desktop', Header::class);
        yield MenuItem::linkToCrud('Commentaires', 'fa fa-user', Comments::class);
        yield MenuItem::linkToCrud('Autorisation à commenter', 'fa fa-user', AuthorizationAvis::class);
    }

    
}
