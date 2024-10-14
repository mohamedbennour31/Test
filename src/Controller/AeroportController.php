<?php

namespace App\Controller;

use App\Entity\Aeroport;
use App\Form\AeroportType;
use App\Repository\AeroportRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AeroportController extends AbstractController
{
    #[Route('/aeroport', name: 'app_aeroport')]
    public function index(): Response
    {
        return $this->render('aeroport/index.html.twig', [
            'controller_name' => 'AeroportController',
        ]);
    }
    #[Route('/listeaeroports', name: 'liste_aeroports')]
    public function read(AeroportRepository $repoAeroport): Response
    {
        $list = $repoAeroport->findAll();
        return $this->render('aeroport/read.html.twig', ['aeroports' => $list]);
    }

    #[Route('/addAeroport', name: 'add_aeroport')]
    public function addAeroport(ManagerRegistry $doctrine, Request $request): Response
    {
        $em = $doctrine->getManager();
        $aeroport = new Aeroport();
        $form = $this->createForm(AeroportType::class, $aeroport);
        $form->add('save', SubmitType::class, ['label' => 'Save Aeroport']);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($aeroport);
            $em->flush();
            return $this->redirectToRoute('liste_aeroports');
        }
        return $this->renderForm('aeroport/add.html.twig', ['form' => $form]);
    }
}
