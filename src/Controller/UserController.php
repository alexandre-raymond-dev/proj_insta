<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Task;
use App\Form\EditProfileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\SerializerInterface;


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

    #[Route('/profile', name: 'profile')]
    public function showProfile(Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $user = $entityManager->getRepository(User::class)->findBy(['id' => $this->getUser()->getId()]);

        return $this->render('profile/profileUser.html.twig',
            array(
                'profile' => $user,
                'controller_name' => 'ProfileController',
            )
        );
    }

    #[Route('/profile/edit', name: 'editProfile')]
    public function register(Request $request,ManagerRegistry $doctrine,ValidatorInterface $validator): Response
    {
        $form = $this->createFormBuilder()
            ->add(child:'username', type:TextType::class)
            ->add(child:'address', type:TextType::class)
            ->add(child:'biography', type:TextType::class)
            ->add(child:'phoneNumber', type:TextType::class)
            ->add(child:'birthday', type:DateType::class)
            ->getForm();

        $form->handleRequest($request);

        $user = $this->getUser();
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setUsername($form->get('username')->getData());
            $user->setAddress($form->get('address')->getData());
            $user->setBiography($form->get('biography')->getData());
            $user->setBirthday($form->get('birthday')->getData());
            $user->setPhoneNumber($form->get('phoneNumber')->getData());

            $this->addFlash('success', 'Vos modifications ont bien été prises en compte !');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/registerProfile.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/user/find', name: 'app_user')]
    public function getAllUsers(UserRepository $userRepository, SerialisezInterface $serial):JsonResponse{
        $userList = $userRepository->findAll();
        $jsonUserList = $serial->serialize($userList, 'json');
        return new JsonReponse($jsonUserList, Response::HTTP_OK, [], true);
    }

    #[Route('/user/find', name: 'app_user', methods: ['GET'])]
    public function getFriendList(UserRepository $userRepository, SerialisezInterface $serial, int $id):JsonResponse{
        //$user = $userRepository->find($id); pas sur de ça
        //Récupérer l'utilisateur dans une variable $user
        //mettre les amis(objet User) de $user dans une $friendList, probablement une boucle ?
        //Possible de rajouter un OneToMany sur lui même ? si oui il faudrait juste une fonction getFriends dans User qui renvoie une liste de user, et on peut la parcourir

        $user = $userRepository->find($id);
        $friendList = $user->getFriendList();
        $jsonFriendList = $serial->serialize($friendList, 'json', ['groups' => 'getFriends']); //Il faudra peut être ajouter un ['groups' => nomdugrp] si on fait un OneToMany
        return new JsonReponse($jsonFriendList, Response::HTTP_OK, [], true);

    }


    #[Route('/showProfile', name: 'showProfile')]
    public function gallery(Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $user = $entityManager->getRepository(User::class)->findOneBy(['id' => $this->getUser()->getId()]);

        return $this->render('profile/profileUser.html.twig',
            array(
                'profile' => $user,
                'controller_name' => 'ProfileController',
            )
        );
    }
}
