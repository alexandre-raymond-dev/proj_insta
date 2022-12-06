<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\EditProdileType;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'profile')]
    public function showProfile(Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $profile = $entityManager->getRepository(Profile::class)->findAll();

        return $this->render('profile/profileUser.html.twig',
            array(
                'profile' => $profile,
                'controller_name' => 'ProfileController',
            )
        );
    }
    #[Route('/dataProfile', name: 'addProfile')]
    public function register(Request $request,ManagerRegistry $doctrine,ValidatorInterface $validator): Response
    {
        $profile = new Profile();
        
        $entityManager = $doctrine->getManager();

        $form = $this->createForm(EditProdileType::class, $profile);
        $form->handleRequest($request);
        
        $user = new User();
        $objUs = $doctrine->getRepository(User::class)->find(1);
        
        $user = $this->getUser();
        var_dump($this->getUser());
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $profile->setAdresse($profile->getAdresse());
            $profile->setDescription($profile->getDescription());
            $profile->setAnniversaire($profile->getAnniversaire());
            $profile->setTelephone($profile->getTelephone());
            $profile->setGenre($profile->getGenre());
            $profile->setProfile($this->getUser());
            
            if($profile->setProfile()){
                $this->addFlash('errorAjoutProfile', 'Information ajoute dans database pour modifier vos données aller dans votre page profile');
                return $this->redirectToRoute('addProfile');
            }


            var_dump($user->getEmail());
            $entityManager->persist($profile);
            $entityManager->flush();
            $this->addFlash('success', 'Votre compte a été crée, dirigez vous pour vous connecter.');
            return $this->redirectToRoute('app_login');
        } 
        // on gère les erreurs 
        /*$errors = $validator->validate($profile);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            var_dump($errorsString);
            $this->addFlash('errorProfile', 'Une erreur est survenue lors de l ajout de donnee');
            return $this->redirectToRoute('app_profile');
        }*/

        return $this->render('registration/registerProfile.html.twig', [
            array(
                'registrationForm' => $form->createView(),
                'controller_name' => 'ProfileController'
            )
        ]);
    }

    #[Route('/showProfile', name: 'showProfile')]
    public function gallery(Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $profile = $entityManager->getRepository(Profile::class)->findAll();

        return $this->render('profile/profileUser.html.twig',
            array(
                'profile' => $profile,
                'controller_name' => 'ProfileController',
            )
        );
    }
    
    


    /*#[Route('/profile/edit', name: 'app_profileEdit')]
    public function editProfile(User $user, Request $request): Response
    {
        $this->denyAccessUnlessGranted('profile_edit', $profile);
        $form = $this->createForm(User::class, $profile);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            return $this->redirectToRoute('HomePage');
        }

        return $this->render('users/edit/edit.html.twig', [
            'form' => $form->createView(),
            'annonce' => $user
        ]);
    }*/


}
