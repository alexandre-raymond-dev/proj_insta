<?php

namespace App\Controller;

use Doctrine\DBAL\Types\Types;
use App\Entity\Photo;
use App\Entity\Album;
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

class AlbumController extends AbstractController
{
    #[Route('/album', name: 'app_album')]
    public function index(): Response
    {
        return $this->render('album/index.html.twig', [
            'controller_name' => 'AlbumController',
        ]);
    }

    #[Route('/add_album', name: 'album')]
    public function addAlbum(Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $album = new Album();

        $formBuilder = $this->container->get('form.factory')->createBuilder();

        $formBuilder
            ->add('title', TextType::class)
            ->add('description', TextareaType::class,['attr' => ['rows' => 10, 'cols' => 43, 'class' => 'text_editor'], 'label' => 'description'],)
            ->add('private', ChoiceType::class, [
                'choices' => [
                    'Public' => false,
                    'Private' => true
                ]
            ])
        ;

        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $album->setTitle($form->get('title')->getData());
            $album->setDescription($form->get('description')->getData());
            $album->setPrivate($form->get('private')->getData());
            $album->setUserid($id);

            $entityManager->persist($album);
            $entityManager->flush();

            return $this->redirectToRoute('app_album');
        }

        return $this->render('gallery/addalbum.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'AlbumController',
        ]);
    }

}
