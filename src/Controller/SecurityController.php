<?php

namespace App\Controller;

use App\Entity\UserProfil;
use App\Form\UserProfilType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{
    #[Route('/inscription', name: 'inscription_')]
    public function inscription(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
    {

        $user = new UserProfil;

        $userForm = $this->createForm(UserProfilType::class, $user);
        $userForm->handleRequest($request);

        if($userForm->isSubmitted() && $userForm->isValid()) {
            $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));
            $em->persist($user);
            $em->flush();
            $this->redirectToRoute('index');
        }


        return $this->render('security/_inscription.html.twig', [
            'form' => $userForm->createView(),
        ]);
    }

    #[Route('/connexion', name: 'connexion_')]
    public function connexion(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $username = $authenticationUtils->getLastUsername();
        
       

        return $this->render('security/_connexion.html.twig', [
            'error' => $error,
            'username' =>$username
        ]);
    }

    #[Route('/logout', name: 'logout_', methods:["GET"])]
    public function deconnexion()
    {
    }

    #[Route('/profil', name: 'profil_')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function profil(Security $security)
    {

        $user = $security->getUser();


        return $this->render('security/_profil.html.twig', [
            'user' => $user
        ]);
    }
}
