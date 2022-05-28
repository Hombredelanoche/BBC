<?php

namespace App\Controller;

use App\Entity\TodoArticles;
use App\Form\TodoArticlesType;
use App\Repository\TodoArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/todo/articles')]
class TodoArticlesController extends AbstractController
{
    #[Route('/', name: 'app_todo_articles_index', methods: ['GET'])]
    public function index(TodoArticlesRepository $todoArticlesRepository): Response
    {
        return $this->render('todo_articles/index.html.twig', [
            'todo_articles' => $todoArticlesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_todo_articles_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,TodoArticlesRepository $todoArticlesRepository): Response
    {
        $todoArticle = new TodoArticles();
        $form = $this->createForm(TodoArticlesType::class, $todoArticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $todoArticlesRepository->add($todoArticle);
            $entityManager->persist($form);
            $entityManager->flush();
            $this->addFlash('createArt', "L'article à bien été crée !");
            return $this->redirectToRoute('app_todo_articles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('todo_articles/new.html.twig', [
            'todo_article' => $todoArticle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_todo_articles_show', methods: ['GET'])]
    public function show(TodoArticles $todoArticle): Response
    {
        return $this->render('todo_articles/show.html.twig', [
            'todo_article' => $todoArticle,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_todo_articles_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TodoArticles $todoArticle, TodoArticlesRepository $todoArticlesRepository): Response
    {
        $form = $this->createForm(TodoArticlesType::class, $todoArticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $todoArticlesRepository->add($todoArticle);
            return $this->redirectToRoute('app_todo_articles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('todo_articles/edit.html.twig', [
            'todo_article' => $todoArticle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_todo_articles_delete', methods: ['POST'])]
    public function delete(Request $request, TodoArticles $todoArticle, TodoArticlesRepository $todoArticlesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$todoArticle->getId(), $request->request->get('_token'))) {
            $todoArticlesRepository->remove($todoArticle);
        }

        return $this->redirectToRoute('app_todo_articles_index', [], Response::HTTP_SEE_OTHER);
    }
}
