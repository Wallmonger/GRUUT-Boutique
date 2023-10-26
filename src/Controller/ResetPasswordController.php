<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Classe\Cart;
use App\Entity\ResetPassword;
use App\Entity\User;
use App\Form\ResetPasswordType;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ResetPasswordController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/mot-de-passe-oublie', name: 'app_reset_password')]

    public function index(Request $request, Cart $cart): Response
    {
        if($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        if($request->get('email')) {
            $user = $this->entityManager->getRepository(User::class)->findOneByEmail($request->get('email'));
            
            if($user) {
                // 1 : Enregister en base la demande de reset_password avec user, token et createdAt.

                $reset_password = new ResetPassword();
                $reset_password->setUser($user);
                $reset_password->setToken(uniqid());
                $reset_password->setCreatedAt(new \DateTimeImmutable());

                $this->entityManager->persist($reset_password);
                $this->entityManager->flush();

                // 2 : Envoyer un mail à l'utilisateur avec un lien lui permettant de mettre à jour son Mdp

                $url = $this->generateUrl('app_update_password', [
                    'token' => $reset_password->getToken()
                ]);
                

                $content = "Bonjour ".$user->getFirstname()."<br>Vous avez demandé à réinitialiser votre mot de passe sur la boutique Gruut.<br><br>";
                $content .= "Merci de bien vouloir cliquer sur le lien suivant pour <a href='".$url."'>mettre à jour votre mot de passe</a>.";

                

                $mail = new Mail();
                $mail->send($user->getEmail(), $user->getFirstname().' '.$user->getLastname(), 'Réinitialiser votre mot de passe sur la boutique gruut', $content);

                $this->addFlash('notice', 'Vous allez recevoir dans quelques secondes un mail avec la procédure pour réinitialiser votre mot de passe.');
            }else {
                $this->addFlash('notice', 'Cette adresse email est inconnue.');
            }
        }

        return $this->render('reset_password/index.html.twig', [
            'cart' => $cart
        ]);
    }

    #[Route('/modifier-mot-de-passe-oublie/{token}', name: 'app_update_password')]

    public function update(Request $request, $token, Cart $cart, UserPasswordHasherInterface $passwordHasher)
    {
        $reset_password = $this->entityManager->getRepository(ResetPassword::class)->findOneByToken($token);

        if(!$reset_password) {
            return $this->redirectToRoute('reset_password');
        }
        //  verifier si createdAT = maintenant + 3h

        $now = new DateTime();
        if($now > $reset_password->getCreatedAt()->modify('+ 3 hour')) {
            
            $this->addFlash('notice', 'Votre demande de mot de passe à expirée. Merci de la renouveller.');
            return $this->redirectToRoute('app_reset_password');
        }
        
        // Rendre une vue avec mot de passe et confirmer votre mot de passe
        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $new_pwd = $form->get('new_password')->getData(); 

        // Encodage des Mdp
            $password = $passwordHasher->hashPassword($reset_password->getUser(), $new_pwd);
            $reset_password->getUser()->setPassword($password);

        // Flush en base de donnée.
            $this->entityManager->flush();

        // Redirection de l'utilisateur vers la page de connexion.
            $this->addFlash('notice', 'Votre mot de passe a bien été mis à jour.');
            return $this->redirectToRoute('app_login');

        }


        return $this->render('reset_password/update.html.twig', [
            'form' => $form->createView(),
            'cart' => $cart
        ]);
    }
}
