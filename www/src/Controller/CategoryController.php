<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

///**
// * @Route("/category")
// */
class CategoryController extends AbstractController
{


    /**
     * @Route("/flows/{id}", name="flows_show", methods={"GET"})
     */
    public function showCategory(Category $category): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $category->getArticles()
        ]);
    }

}
