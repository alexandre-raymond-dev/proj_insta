<?php

namespace App\Controller;

use Doctrine\DBAL\Types\Types;
use App\Entity\Photo;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 
use Symfony\Component\Form\Extension\Core\Type\ButtonType;


class PhotoController extends AbstractController 
{
    #[Route('/photo', name: 'app_photo')]
    public function index(): Response
    {
        return $this->render('gallery/photo/index.html.twig', [
            'controller_name' => 'PhotoController',
        ]);
    }

    #[Route('/gallery', name: 'Gallery')]
    public function seeAll(Request $request, ManagerRegistry $doctrine):  Response
    {
        $entityManager = $doctrine->getRepository(Photo::class);

        $photoList = $entityManager->findAll();

        return $this->render('gallery/gallery.html.twig', [
            'photoList' => $photoList
        ]);
    }

    #[Route('/photo/add', name: 'add_photo')]
    public function add(Request $request, ManagerRegistry $doctrine): Response
    {
        // FORMULAIRE !!!!!

        $entityManager = $doctrine->getManager();

        $photo = new Photo();

        $formBuilder = $this->container->get('form.factory')->createBuilder();

        $formBuilder    
            ->add(
                "title",
                TextType::class,
                array(
                    "label" => "title",
                )
            )
            ->add(
                "description",
                TextType::class,
                array(
                    "label" => "description",
                )
            )
            ->add(
                "visibilite",
                TextType::class,
                array(
                    "label" => "prive or public",
                )
            )
            ->add(
                "photo",
                ButtonType::class,
                [
                    'attr' => ['class' => 'photo'],
                ]
                // array(
                //     "label" => "lien de la photo",
                // )
            )
            ->add(
                "submit",
                SubmitType::class,
                array(
                    "label" => "Submit",
                )
            )
        ;

        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();

            // var_dump($data);

            $photo->setTitle($data["title"]);
            $photo->setDescription($data["description"]);
            $photo->setPrivacy($data["visibilite"]);
            $photo->setUploadDate(new \DateTimeImmutable());
            $photo->setView(1);
            $photo->setImagePath($data["photo"]);

            $entityManager->persist($photo);
            $entityManager->flush();

            return $this->redirectToRoute('add_photo');
        }
        // $photo->setTitle("Photo de profile");
        // $photo->setDescription("ok");
        // $photo->setPrivacy("public");
        // $photo->setUploadDate(new \DateTimeImmutable());
        // $photo->setView(1);
        // $photo->setImagePath("/Users/thomas/Documents/symfony/proj_insta/images");


        // $form = $formBuilder->getForm();
        // $form->handleRequest($request);
        // $entityManager->persist($photo);
        // $entityManager->flush();


        return $this->render(
            'gallery/add.html.twig',
            array(
                'form' => $form->createView(),
                'controller_name' => 'PhotoController'
            )
        );
    }

    #[Route('/photo/delete', name: 'delete_photo')]
    public function delete(Request $request, ManagerRegistry $doctrine): Response
    {
        


        return $this->render('gallery/photo/index.html.twig', [
            'controller_name' => 'PhotoController',
        ]);
    }
}
