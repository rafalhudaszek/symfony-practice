<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @var \App\Entity\Post[]
     */
    private $category;

    /**
     * @Route("/", name="main")
     * @param PostRepository $postRepository
     * @return Response
     */
    public function index(PostRepository $postRepository)
    {

        $actualUser = $this->getUser();
        $posts = $postRepository->findAll();
        return $this->render('main/index.html.twig',[
            'posts' => $posts,
            'actualUser' => $actualUser
        ]);
    }

    /**
     * @Route("/polityka", name="mainPolityka")
     * @param PostRepository $postRepository
     * @return Response
     */
    public function policy(PostRepository $postRepository)
    {

        $actualUser = $this->getUser();
        $posts = $postRepository->findBy(array('category' => 1));
        return $this->render('main/index.html.twig',[
            'posts' => $posts,
            'actualUser' => $actualUser
        ]);
    }

    /**
     * @Route("/swiatopoglad", name="mainSwiatopoglad")
     * @param PostRepository $postRepository
     * @return Response
     */
    public function worldview(PostRepository $postRepository)
    {

        $actualUser = $this->getUser();
        $posts = $postRepository->findBy(array('category' => 2));
        return $this->render('main/index.html.twig',[
            'posts' => $posts,
            'actualUser' => $actualUser
        ]);
    }

    /**
     * @Route("/zycie", name="mainZycie")
     * @param PostRepository $postRepository
     * @return Response
     */
    public function life(PostRepository $postRepository)
    {

        $actualUser = $this->getUser();
        $posts = $postRepository->findBy(array('category' => 4));
        return $this->render('main/index.html.twig',[
            'posts' => $posts,
            'actualUser' => $actualUser
        ]);
    }

    /**
     * @Route("/zwiazek", name="mainZwiazek")
     * @param PostRepository $postRepository
     * @return Response
     */
    public function relationship(PostRepository $postRepository)
    {

        $actualUser = $this->getUser();
        $posts = $postRepository->findBy(array('category' => 3));
        return $this->render('main/index.html.twig',[
            'posts' => $posts,
            'actualUser' => $actualUser
        ]);
    }
}
