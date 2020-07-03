<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

///**
// * @Route("/article")
// */
class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="article_index", methods={"GET"})
     */
    public function index(ArticleRepository $articleRepository, CategoryRepository $categoryRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
//            'categories' => $categoryRepository->findAll()
        ]);
    }

    /**
     * @Route("/admin/article/new", name="article_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/article/{id}", name="article_show", methods={"GET","POST"})
     */
    public function show(Article $article): Response
    {
        $form = $this->createForm(CommentType::class, new Comment());
        return $this->render('article/show.html.twig', [
            'article' => $article,
            'form'    => $form->createView()
        ]);

    }

//    /**
//     * @Route("/article/addcomment/{id}", name="add_comment", methods={"GET","POST"})
//     */
//    public function addComment(Article $article): Response
//    {
////        var_dump($_POST);
////        echo "<br>";
////        var_dump($article);
////        die();
//        return $this->render('article/post.html.twig', [
//            'posts' => $_POST,
//            'article' => $article,
//        ]);
//
//    }

    /**
     * @Route("/flows/{id}", name="flows_show", methods={"GET"})
     */
    public function showCategory(Category $category): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $category->getArticles()
        ]);
    }

    /**
     * @Route("/admin/article/{id}/edit", name="article_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/article/{id}", name="article_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('article_index');
    }
}
