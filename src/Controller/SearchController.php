<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;
use App\Entity\Task;
use App\Form\SearchFormType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class SearchController extends AbstractController
{
    // #[Route('/user', name: 'search_user2')]
    // public function index(): Response
    // {
    //     return $this->render('fotogency-v1/public/blog.html.twig', [
    //         'controller_name' => 'SearchController',
    //     ]);
    // }


    #[Route('/user', name: 'search_user')]
    public function searchUser(Request $request,ManagerRegistry $doctrine): Response
    {
        $user = new User();
        $entityManager = $doctrine->getManager();
        $searchForm = $this->createForm(SearchFormType::class, $user);
        $searchForm->handleRequest($request);
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $email = $user->setEmail($user->getEmail());
            $dataEmail = $searchForm->getData();
        }
        
        $users = $entityManager->getRepository(User::class)->findAll();

        return $this->render('fotogency-v1/public/blog.html.twig',
                array('users'=>$users,
                'controller_name' => 'SearchController'
                )
            );
       
        
    }

}
