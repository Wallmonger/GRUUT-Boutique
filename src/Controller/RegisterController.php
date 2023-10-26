<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Classe\Mail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/inscription', name: 'app_register')]
    public function index(Request $request, UserPasswordHasherInterface $encoder, Cart $cart): Response
    {
        $notification = null;

        $user = new User ();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $search_email = $this->entityManager->getRepository(User::class)->findOneByEmail($user->getEmail());

            if(!$search_email) {
                $password = $encoder->hashPassword($user, $user->getPassword());
            
                $user->setPassword($password);

                $this->entityManager->persist($user);
                $this->entityManager->flush();

                $mail = new Mail();
                $content = "Bonjour".$user->getFirstname()."<br\> Bienvenue sur le site Gruut dédié aux meubles made in Wood";
                $mail->send($user->getEmail(), $user->getFirstname(), 'Bienvenue sur Gruut', $content);

                $notification = "Votre inscription s'est correctement déroulé. Vous pouvez dès à présent vous connecter à votre compte Gruut";
            } else {
                $notification = "L'email que vous avez renseigné existe déjà";
            }
        }

        return $this->render('register/index.html.twig', [
            'form'=> $form->createView(),
            'notification' => $notification,
            'cart' => $cart->getFull()
        ]);
    }
}


//chap 60 à 5min20 