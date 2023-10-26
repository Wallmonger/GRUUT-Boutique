<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Classe\Search;
use App\Entity\AuthorizationAvis;
use App\Entity\Comments;
use App\Entity\MaterialsOfProduct;
use App\Entity\Product;
use App\Form\CommentsType;
use App\Form\SearchColorType;
use App\Form\SearchType;
use App\Repository\AuthorizationAvisRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // GENERAL PRODUCTS =================================

    #[Route('/product', name: 'app_product')]
    public function index(Request $request, Cart $cart): Response
    {
        $products = $this->entityManager->getRepository(Product::class)->findAll();

        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $products = $this->entityManager->getRepository(Product::class)->findWithSearch($search);
        }


        return $this->render('product/index.html.twig', [
            'products' => $products,
            'form' => $form->createView(),
            'cart' => $cart->getFull()
        ]);

    }








    // SALON PRODUCTS =================================

    #[Route('/product_salon', name: 'app_product_salon')]
    public function indexsalon(Request $request, Cart $cart): Response
    {

        $products = $this->entityManager->getRepository(Product::class)->findAll();

        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $products = $this->entityManager->getRepository(Product::class)->findWithSearch($search);
        }
        
        return $this->render('product/salon.html.twig', [
            'products' => $products,
            'form' => $form->createView(),
            'cart' => $cart->getFull()
        ]);

    }







    // SALLE A MANGER PRODUCTS =================================

    #[Route('/product_dining', name: 'app_product_dining')]
    public function indexsalle(Request $request, Cart $cart): Response
    {
        $products = $this->entityManager->getRepository(Product::class)->findAll();

        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $products = $this->entityManager->getRepository(Product::class)->findWithSearch($search);
        }
        
        
        return $this->render('product/dining.html.twig', [
            'products' => $products,
            'form' => $form->createView(),
            'cart' => $cart->getFull()
        ]);

    }







    // CHAMBRES PRODUCTS =================================

    #[Route('/product_chambres', name: 'app_product_chambres')]
    public function indexchambres(Request $request, Cart $cart): Response
    {
        $products = $this->entityManager->getRepository(Product::class)->findAll();

        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $products = $this->entityManager->getRepository(Product::class)->findWithSearch($search);
        }
        
        return $this->render('product/chambres.html.twig', [
            'products' => $products,
            'form' => $form->createView(),
            'cart' => $cart->getFull()
        ]);

    }






    // CUISINE PRODUCTS =================================

    #[Route('/product_cuisine', name: 'app_product_cuisine')]
    public function indexcuisine(Request $request, Cart $cart): Response
    {
        $products = $this->entityManager->getRepository(Product::class)->findAll();

        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $products = $this->entityManager->getRepository(Product::class)->findWithSearch($search);
        }
        
        return $this->render('product/cuisine.html.twig', [
            'products' => $products,
            'form' => $form->createView(),
            'cart' => $cart->getFull()
        ]);

    }


    // PAGE PRODUIT 5 ETOILES

    #[Route('/product_best', name: 'app_product_best')]
    public function indexbest(Request $request, Cart $cart): Response
    {
        $products = $this->entityManager->getRepository(Product::class)->findAll();

        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $products = $this->entityManager->getRepository(Product::class)->findWithSearch($search);
        }


        return $this->render('product/fivestars.html.twig', [
            'products' => $products,
            'form' => $form->createView(),
            'cart' => $cart->getFull()
        ]);

    }




    // PAGE PRODUIT SLUG ==========================================================================

    #[Route('/product/{slug}', name: 'app_product_slug')]
    public function show($slug, Cart $cart, Request $request, AuthorizationAvisRepository $avis): Response
    {
        $product = $this->entityManager->getRepository(Product::class)->findOneBySlug($slug);
        $products = $this->entityManager->getRepository(Product::class)->findByIsBest(1);
        
        // THIS IS A TEST FOR THE MATERIALS INPUT

        if($product) {
            $this->redirectToRoute('app_product');
        }

        // Commentaires 
        // On crée le commentaire "vierge"
        $user = $this->getUser();
        
        $comment = new Comments;
        // On génère le formulaire
        $commentForm = $this->createForm(CommentsType::class, $comment);
        $commentForm->handleRequest($request);

        // Variable pour vérifier si l'utilisateur n'a pas déjà publié de commentaire
        $commentPostVerify = false;
        

        //On vérifie alors à l'aide du repository si il y a un commentaire pour ce produit

        if ($user) {               // On vérifie si il y a un utilisateur, sinon conflit en chercher le getId pour la correspondance
            $correspondance = $this->entityManager->getRepository(Comments::class)->findUserReplies($product, $user->getId());
            
            if($correspondance)   // Si l'utilisateur a déjà publié un commentaire
            {
                $commentPostVerify = true;
            } 
        }
        // Traitement du formulaire
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {

            
            
            $comment->setCreatedAt(new DateTime());
            $comment->setProduct($product);
            
            $comment->setUser($user); 
            $comment->setUsername($user->getFirstname());
            
            $parentid = $commentForm->get("parentid")->getData();           // On récupére le parentid du formulaire, que nous avons défini en hidden et non mapped car sinon il attendrait une entité
                                                                            // De cette manière on peut tout simplement définir un nombre, récupéré en html
            // On va ensuite chercher le commentaire correspondant
            if ($parentid) {
            $parent = $this->entityManager->getRepository(Comments::class)->find($parentid);
            $comment->setParent($parent);
            }
            $this->entityManager->persist($comment);
            $this->entityManager->flush();
            $this->addFlash('success', 'Vote commentaire a bien été envoyé');
            return $this->redirect($request->headers->get('referer'));
            
        }
        
        $AuthorizeComment = false;

        $isUserAllowed = $this->entityManager->getRepository(AuthorizationAvis::class)->findByProduct($product);
        for ($i = 0; $i < count($isUserAllowed); $i++) {
            if($isUserAllowed[$i]->getUser() == $this->getUser()) {
                $AuthorizeComment = true;
            };
        }

        

        
        
        return $this->render('product/productslug.html.twig', [
            'product' => $product,
            'products' => $products,
            'cart' => $cart->getFull(),
            'commentForm' => $commentForm->createView(),
            'AuthorizeComment' => $AuthorizeComment,
            'commentPostVerify' => $commentPostVerify
            
            
        ]);
    }
}
