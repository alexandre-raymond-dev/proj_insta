<?php

namespace App\Controller;

use Doctrine\DBAL\Types\Types;
use App\Entity\Photo;
use App\Entity\Album;
use App\Entity\User;
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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
        $entityManager_album = $doctrine->getRepository(Album::class);

        $user = $doctrine->getRepository(User::class)->findBy(['id' => $this->getUser()->getId()]);
        
        //$photoList = $entityManager->findAll();
        //$albumList = $entityManager_album->findAll();
        $photoList = $entityManager->findBy(['id' => $user->getId()]);
        $albumList = $entityManager_album->findBy(['id' => $user->getId()]);;

        return $this->render('gallery/gallery.html.twig', [
            'photoList' => $photoList,
            'albumList' => $albumList,

        ]);
    }

    #[Route('/add_photo', name: 'add_photo')]
    public function add(Request $request, ManagerRegistry $doctrine): Response
    {

        $entityManager = $doctrine->getManager();
        $entityManger_album = $doctrine->getRepository(Album::class);

        $albums = $entityManger_album->findAll();

        for ($i = 0; $i < count($albums); $i++) {
            $albumList[$albums[$i]->getTitle()] = $albums[$i]->getId();
        }

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
                TextareaType::class,[
                    'attr' => ['rows' => 10, 'cols' => 43, 'class' => 'text_editor'],
                ],
                array(
                    "label" => "description",
                )
            )
            ->add(
                "private",
                ChoiceType::class,
                array(
                    "label" => "visibilite",
                    "choices" => array(
                        "public" => false,
                        "private" => true,
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
                "album",
                ChoiceType::class,
                array(
                    "label" => "album",
                    "choices" => $albumList,
                )
            )
        ;

        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();
            
            //var_dump($data);

            $photo->setTitle($data["title"]);
            $photo->setDescription($data["description"]);
            $photo->setPrivate($data["visibilite"]);
            $photo->set(new \DateTimeImmutable());
            $uploadedFile = $form->get('photo')->getData();
            
            $album = $entityManger_album->find($data["album"]);
            
            $photo->addAlbum($album);

            // -- Upload de l'image
            $fichier = md5(uniqid()).'.'.$uploadedFile->guessExtension();
            $uploadedFile->move('./assets/img/gallery', $fichier);
            $photo->setImagePath('./assets/img/gallery/'.$fichier);
            
            $entityManager->persist($photo);
            $entityManager->flush();

            return $this->redirectToRoute('add_photo');
        }

        return $this->render('gallery/addphoto.html.twig',
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