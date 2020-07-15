<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Tag;
use App\Form\TagType;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tag")
 */
class TagController extends AbstractController
{
//    /**
//     * @Route("/", name="tag_index", methods={"GET"})
//     */
//    public function index(TagRepository $tagRepository): Response
//    {
//        return $this->render('tag/index.html.twig', [
//            'tags' => $tagRepository->findAll(),
//        ]);
//    }


    /**
     * @Route("/{id}", name="tag_show", methods={"GET"})
     */
    public function show(Tag $tag): Response
    {
//        die(var_dump($tag->getArticles()));

        return $this->render('article/index.html.twig', [
            'articles' => $tag->getArticles()
        ]);
    }

}
