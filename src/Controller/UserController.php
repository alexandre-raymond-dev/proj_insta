<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;
use App\Entity\Task;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
   
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }


    #[Route('/user/add', name: 'app_user')]
    public function createUser(Request $request,ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher): Response
    {
        $entityManager = $doctrine->getManager();
        $user = new User();
        $plaintextPassword = "hello123";

        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user
            ->setUserName("Joe Doe")
            ->setEmail("joe.doe@root.com")
            ->setPassword($hashedPassword)
            ;
        
       
       
        $form = $this->createFormBuilder($user)
            ->add('UserName', TextType::class)
            ->add('Email',TextType::class)
            ->add('Password', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Create User'])
            ->getForm();
        
           /* return $this->renderForm('user/index.html.twig', [
                'form' => $form,
            ]);*/

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid())
            {
                $data = $form->getData();
                $entityManager->persist($user);
                $entityManager->flush();
                return $this->redirectToRoute('user');
            }
    
    
            return $this->render(
                'user/form.html.twig',
                array(
                'form' => $form->createView(),
                )
            );
    
    }
}
