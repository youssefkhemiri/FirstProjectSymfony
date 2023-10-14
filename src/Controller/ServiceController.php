<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    #[Route('/service/{name}', name: 'app_service')]
    // public function index(): Response
    // {
    //     return $this->render('service/index.html.twig', [
    //         'controller_name' => 'ServiceController',
    //     ]);
    // }
    public function showService($name)  : Response{
        return $this->render('service/show.html.twig', [
            'namee' => $name,
        ]);
    }

    #[Route('/service2', name: 'app_service_index')]
    public function goToIndex()
    {
        // Utilisez la méthode `redirectToRoute` pour rediriger vers la route "home_index".
        return $this->redirectToRoute('app_home');
    }

    // #[Route('/service3', name: 'app_service_index2')]
    // public function goToIndex2()
    // {
    //     return $this->render('home/index.html.twig', [
    //         'controller_name' => 'HomeController',
    //     ]);
    // }
    
}
