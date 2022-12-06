<?php

namespace App\Controller;

use App\Controller;
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
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\File;

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

    #[Route('/gallery/add', name: 'add_photo')]
    public function add(Request $request, ManagerRegistry $doctrine): Response
    {

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
                ChoiceType::class,
                array(
                    "label" => "visibilite",
                    "choices" => array(
                        "public" => 0,
                        "private" => 1,
                    ),
                )
            )
            ->add(
                "photo",
                FileType::class,
                array(
                    "label" => "photo",
                ),
                new File([
                    'maxSize' => '1024k',
                    'mimeTypes' => [
                        'image/*',
                    ],
                        'mimeTypesMessage' => 'Please upload a valid image',
                    ]),
                [
                    'attr' => ['class' => 'photo'],
                    'mapped' => false,
                ]
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

            var_dump($data);

            $photo->setTitle($data["title"]);
            $photo->setDescription($data["description"]);
            $photo->setPrivacy($data["visibilite"]);
            $photo->setUploadDate(new \DateTimeImmutable());
            $photo->setView(1);
            $uploadedFile = $form->get('photo')->getData();

            // echo $uploadedFile;

            // -- Upload de l'image
            $fichier = md5(uniqid()).'.'.$uploadedFile->guessExtension();
            $uploadedFile->move('./assets/img/', $fichier);
            $photo->setImagePath('./assets/img/'.$fichier);
            
            $entityManager->persist($photo);
            $entityManager->flush();

            return $this->redirectToRoute('add_photo');
        }

        return $this->render('gallery/add.html.twig',
            array(
                'form' => $form->createView(),
                'controller_name' => 'PhotoController'
            )
        );
    }

    #[Route('/photo/delete', name: 'delete_photo')]
    public function delete(Request $request, ManagerRegistry $doctrine): Response
    {
        


        return $this->render('test.html.twig', [
            'controller_name' => 'PhotoController',
        ]);
    }
}