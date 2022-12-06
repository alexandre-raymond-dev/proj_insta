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
        $entityManager = $doctrine->getManager();

        $users = $entityManager->getRepository(User::class)->findAll();
        // var_dump($users);

        return $this->render('fotogency-v1/public/blog.html.twig',
                array('users'=>$users,
                'controller_name' => 'SearchController'
                )
            );
       
        
        /*if(isset($_POST["submit"])){
            $str = $_POST["email"];
            $sth = $con_>prepare("SELECT * FROM 'user' WHERE email = '$str'");

            $sth->setFetchMode(PDO:: FETCH_OBJ);
            $sth->execute();

            if($row = $sth->fetch()){
                 ?>
                 <br><br><br>
                 <table>
                    <tr>
                        <th>email</th>
                        <th>username</th>
                    </tr>
                    <tr>
                        <td><?php echo $row->email; ?></td>
                        <td><?php echo $row->username;?></td>
                    </tr>

                 </table>
                 <?php 
            } 
            

        }

       
       
    
            return $this->render(
                'public/blog.html.twig',
                
            );*/
    
    
    
    
    }

}
