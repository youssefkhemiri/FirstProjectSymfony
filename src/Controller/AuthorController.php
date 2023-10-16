<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    #[Route('/getall', name: 'app_list_authors')]
    public function Affiche(AuthorRepository $repository): Response
    {
        $authors = $repository->findAll();
        return $this->render('author/affiche.html.twig', [
            'list' => $authors,
        ]);
    }

    #[Route('/addyoussef', name: 'app_youssef')]
    public function addStatique(ManagerRegistry $doctrine): Response
    {
        $author = new Author();
        $author->setUsername('Youssef Hugo');
        $author->setEmail('youssef@gmail.com');

        //créer une instance de entity manager
        $em=$doctrine->getManager();
        //créer la requête d'ajout
        $em->persist($author);

        //exécuter la requête
        $em->flush();

        return $this->redirectToRoute('app_list_authors');
    }

    #[Route("/addform", name: "app_add_author")]
    public function Addwithform(Request $request, ManagerRegistry $doctrine): Response
    {
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);
        $form->add('Save_me', SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //créer une instance de entity manager
            $em=$doctrine->getManager();
            //créer la requête d'ajout
            $em->persist($author);

            //exécuter la requête
            $em->flush();

            return $this->redirectToRoute('app_list_authors');
        }
        return $this->render('author/add.html.twig', [
            'f' => $form->createView(),
        ]);
    }
    
    #[Route("/editform/{id}", name: "app_edit_author")]
    function edit(AuthorRepository $rep, $id, Request $r){
        $author = $rep->find($id);
        $form = $this->createForm(AuthorType::class, $author);
        $form->add('Save', SubmitType::class);
        $form->handleRequest($r);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('app_list_authors');
        }
        return $this->render('author/edit.html.twig', [
            'f' => $form->createView(),
        ]);
    }
    #[Route("/delete/{id}", name: "app_delete_author")]
    function delete(AuthorRepository $rep, $id, Request $r){
        $author = $rep->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($author);
        $em->flush();
        return $this->redirectToRoute('app_list_authors');
    }

}
