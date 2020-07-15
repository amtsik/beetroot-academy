<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Tag;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\TagRepository;
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
     * @Route("/article/{id}", name="article_show", methods={"GET","POST"})
     */
    public function show(Article $article): Response
    {
        $form = $this->createForm(CommentType::class, new Comment());
        return $this->render('article/show.html.twig', [
            'article' => $article,
//            'tags' => $tag,
            'form'    => $form->createView()
        ]);

    }

    /**
     * @Route("/article/tag/{id}", name="article_tag_show", methods={"GET","POST"})
     */
    public function showTag(ArticleRepository $articleRepository, CategoryRepository $categoryRepository, TagRepository $tagRepository): Response
    {
        return $this->render('tag/index.html.twig', [
            'articles' => $articleRepository->findAll(),
            'categories' => $categoryRepository->findAll(),
            'tags' => $tagRepository->findAll()
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


}
