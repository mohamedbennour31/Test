<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

//#[Route('/service',)]
class ServiceController extends AbstractController
{
    #[Route('/service', name: 'home_index')]
    public function index(): Response
    {
        return $this->render('service/index.html.twig', [
            'controller_name' => 'ServiceController',
        ]);
    }
    /*#[Route('/service', name: 'app_service')]
    public function index(): Response
    {
        return new Response("Bonjour les amis");
    }*/
    /*  #[Route('/service/{name}', name: 'app_service')]
    public function showService($name): Response
    {
        return new Response("service " . $name);
        return $this;
    }
*/
    #[Route('/service/{name}', name: 'app_service')]
    public function showService($name): Response
    {

        return $this->render('service/showService.html.twig', ['name' => $name]);
    }
    #[Route('service/goToIndex', name: 'app_service')]
    public function goToIndex(): Response
    {
        return $this->redirectToRoute('home_index');
    }
}
