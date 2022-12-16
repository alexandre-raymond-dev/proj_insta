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

    #[Route('/dataProfile', name: 'addProfile')]
    public function register(Request $request,ManagerRegistry $doctrine,ValidatorInterface $validator): Response
    {
        $user = new User();

        $entityManager = $doctrine->getManager();

        $form = $this->createForm(EditProfileType::class, $user);
        $form->handleRequest($request);

        $objUs = $doctrine->getRepository(User::class)->find(1);

        $user = $this->getUser();
        var_dump($this->getUser());
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setAddress($user->getAddress());
            $user->setBiography($user->getBiography());
            $user->setBirthday($user->getBirthday());
            $user->setPhoneNumber($user->getPhoneNumber());
            $user->setGender($user->getGender());

//             if($user->setProfile()){
//                 $this->addFlash('errorAjoutProfile', 'Information ajoute dans database pour modifier vos données aller dans votre page profile');
//                 return $this->redirectToRoute('addProfile');
//             }


            var_dump($user->getEmail());
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Votre compte a été crée, dirigez vous pour vous connecter.');
            return $this->redirectToRoute('app_login');
        }
        // on gère les erreurs
        /*$errors = $validator->validate($user);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            var_dump($errorsString);
            $this->addFlash('errorProfile', 'Une erreur est survenue lors de l ajout de donnee');
            return $this->redirectToRoute('app_profile');
        }*/

//         var_dump($form);

        return $this->render('registration/registerProfile.html.twig', [
            array(
                'registrationForm' => $form->createView(),
                'controller_name' => 'ProfileController'
            )
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
