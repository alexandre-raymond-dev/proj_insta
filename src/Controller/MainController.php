<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="HomePage")
     */
    public function index(): Response
    {
        return $this->render('fotogency-v1/public/index.html.twig', [
            'controller_name' => 'MainController',
        ]);

        
    }

    /**
     * @Route("/service", name="Service")
     */
    public function viewService(): Response
    {
        return $this->render('fotogency-v1/public/exhibitions.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
     /**
     * @Route("/blog", name="Blog")
     */
    public function viewContact(): Response
    {
        return $this->render('fotogency-v1/public/blog.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    
     /**
     * @Route("/Portfolio", name="Portfolio")
     */
    public function viewPortfolio(): Response
    {
        return $this->render('fotogency-v1/public/portfolio.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
     /**
     * @Route("/about", name="About")
     */
    public function viewAbout(): Response
    {
        return $this->render('fotogency-v1/public/about.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
