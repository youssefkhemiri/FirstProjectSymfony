<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route("/addform2", name: "app_add_book")]
    public function Addwithform(Request $request, ManagerRegistry $doctrine): Response
    {
        $author = new Book();
        $form = $this->createForm(BookType::class, $author);
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

    #[Route("/editbook/{id}", name: "app_edit_book")]
    function edit(BookRepository $rep, $id, Request $r){
        $book = $rep->find($id);
        $form = $this->createForm(BookType::class, $book);
        $form->add('published');
        $form->add('Save', SubmitType::class);
        $form->handleRequest($r);
        

        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            // return $this->redirectToRoute('app_list_authors');
            return $this->render('author/editform.html.twig');
        }
        return $this->render('author/edit.html.twig', [
            'f' => $form->createView(),
        ]);
    }

    #[Route('/get_pub_books', name: 'app_list_books')]
    public function Affiche(BookRepository $repository): Response
    {
        $books = $repository->findall();
        return $this->render('author/affichebook.html.twig', [
            'list' => $books,
        ]);
    }

}
