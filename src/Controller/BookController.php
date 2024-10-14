<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\AuthorType;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('/affichage', name: 'affichageBooks')]
    public function read(BookRepository $repoBook): Response
    {
        $list = $repoBook->findAll();
        return $this->render('book/afficherLivres.html.twig', ['books' => $list]);
    }

    #[Route('/addBook', name: 'add_book')]
    public function addBook(ManagerRegistry $doctrine, Request $request): Response
    {
        $em = $doctrine->getManager();
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->add('save', SubmitType::class, ['label' => 'Save Book']);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($book);
            $em->flush();
            return $this->redirectToRoute('affichageBooks');
        }
        return $this->renderForm('book/addBook.html.twig', ['form' => $form]);
    }
}
