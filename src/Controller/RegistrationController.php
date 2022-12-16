<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\UsersAuthenticator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegistrationController extends AbstractController
{

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, ManagerRegistry $doctrine, ValidatorInterface $validator): Response
    {
        $user = new User();
        $entityManager = $doctrine->getManager();

        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setEmail($user->getEmail());
            $user->setUsername($user->getUsername());
            $user->setName($user->getName());
            $user->setPrivate(True);
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Votre compte a été crée, dirigez vous pour vous connecter.');
            return $this->redirectToRoute('app_login');
        } 

        // on gère les erreurs 
        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            var_dump($errorsString);
            $this->addFlash('errorEmail', 'Email existe déjà, Veuillez rentrer un autre mail');
            return $this->redirectToRoute('app_register');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

}
