<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    #[Route('/showauthor/{name}', name: 'app_author')]
    public function showAuthor($name): Response
    {
        return $this->render('author/show.html.twig', [
            'name' => $name,
        ]);
    }

    #[Route('/list', name: 'app_list')]
    public function list()
    {
        $authors = array(
            array('id' => 1, 'picture' => '/images/victor-hugo.jpg', 'username' => 'Victor Hugo', 'email' => 'victor@gmail.com', 'nb_books'=>100),
            array('id' => 2, 'picture' => '/images/william-shakespeare.jpg', 'username' => 'William Shakespeare', 'email' => 'baudelaire@gmail.com', 'nb_books'=>50),
            array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg', 'username' => 'Taha Hussein', 'email' => 'taha@gmail.com', 'nb_books'=>300), 
        );
        return $this->render('author/list.html.twig',
        ['list'=>$authors]);
    }

    #[Route('/author/{id}', name: 'app_author_details')]
    public function authorDetails($id){
        $authors = array(
            array('id' => 1, 'picture' => '/images/victor-hugo.jpg', 'username' => 'Victor Hugo', 'email' => 'victor@gmail.com', 'nb_books'=>100),
            array('id' => 2, 'picture' => '/images/william-shakespeare.jpg', 'username' => 'William Shakespeare', 'email' => 'baudelaire@gmail.com', 'nb_books'=>50),
            array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg', 'username' => 'Taha Hussein', 'email' => 'taha@gmail.com', 'nb_books'=>300), 
        );
        return $this->render('author/showAuthor.html.twig', [
            'list' => $authors,
            'id' => $id,
        ]);
    }
}
