<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    #[Route('/showAuthor/{id}', name: 'app_showAuthor')]
    public function showAuthor($id): Response
    {

        $authors = [
            1 => ['id' => 1, 'picture' => '/images/Victor-Hugo.jpg', 'username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com', 'nb_books' => 100],
            2 => ['id' => 2, 'picture' => '/images/william.jpg', 'username' => 'William Shakespeare', 'email' => 'william.shakespeare@gmail.com', 'nb_books' => 200],
            3 => ['id' => 3, 'picture' => '/images/Taha-Hussein.jpg', 'username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300],
        ];


        if (!isset($authors[$id])) {
            throw $this->createNotFoundException('Author not found');
        }

        $author = $authors[$id];

        return $this->render('author/showAuthor.html.twig', [
            'author' => $author,
        ]);
    }

    #[Route('/listAuthors', name: 'app_listAuthors')]
    public function listAuthors(): Response
    {
        $authors = array(
            array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg', 'username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com', 'nb_books' => 100),
            array('id' => 2, 'picture' => '/images/william.jpg', 'username' => 'William Shakespeare', 'email' => 'william.shakespeare@gmail.com', 'nb_books' => 200),
            array('id' => 3, 'picture' => '/images/Taha-Hussein.jpg', 'username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300),
        );

        if (!isset($authors) || empty($authors)) {
            $authors = [];
        }


        $totalBooks = array_sum(array_column($authors, 'nb_books'));

        return $this->render('author/list.html.twig', [
            'authors' => $authors,
            'totalBooks' => $totalBooks,
        ]);
    }
    #[Route('/author/{id}', name: 'app_author_details')]
    public function authorDetails($id): Response
    {

        $authors = [
            1 => ['id' => 1, 'picture' => '/images/Victor-Hugo.jpg', 'username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com', 'nb_books' => 100],
            2 => ['id' => 2, 'picture' => '/images/william.jpg', 'username' => 'William Shakespeare', 'email' => 'william.shakespeare@gmail.com', 'nb_books' => 200],
            3 => ['id' => 3, 'picture' => '/images/Taha-Hussein.jpg', 'username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300],
        ];


        if (!isset($authors[$id])) {
            throw $this->createNotFoundException('Author not found');
        }

        $author = $authors[$id];

        return $this->render('author/details.html.twig', [
            'author' => $author,
        ]);
    }
    #[Route('/read', name: 'read')]
    public function read(AuthorRepository $repoAuthor): Response
    {
        $list = $repoAuthor->findAll();
        return $this->render('author/read.html.twig', ['authors' => $list]);
    }
    #[Route('/delete/{id}', name: 'delete')]
    public function delete($id, AuthorRepository $repoAuthor, ManagerRegistry $doctrine): Response
    {
        $author = $repoAuthor->find($id);
        $em = $doctrine->getManager();
        $em->remove($author);
        $em->flush();
        return $this->redirectToRoute('read');
    }
    #[Route('/add', name: 'add')]
    public function add(ManagerRegistry $doctrine, Request $request): Response
    {
        $em = $doctrine->getManager();
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);
        $form->add('save', SubmitType::class, ['label' => 'Save Author']);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($author);
            $em->flush();
            return $this->redirectToRoute('read');
        }
        return $this->renderForm('author/add.html.twig', ['form' => $form]);
    }

    #[Route('/author/update/{id}', name: 'update_author')]
    public function update(ManagerRegistry $doctrine, Request $request, int $id): Response
    {
        $em = $doctrine->getManager();
        $author = $em->getRepository(Author::class)->find($id);
        if (!$author) {
            throw $this->createNotFoundException('No author found for id ' . $id);
        }
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('read');
        }
        return $this->renderForm('author/update.html.twig', [
            'form' => $form,
            'author' => $author,
        ]);
    }
}
