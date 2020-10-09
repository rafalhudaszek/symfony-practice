<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post", name="post")
 */
class PostController extends AbstractController
{

    /**
     * @Route("/", name="postIndex")
     */
    public function index()
    {
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }

    /**
     * @Route("/create", name="create")
     * @param Request $request
     */
    public function create(Request $request)
    {
        //$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if(!$this->getUser())
        {
            $this->addFlash('error', 'Musisz być zalogowany by stworzyć myśl');
            return $this->redirect($this->generateUrl('main'));
        }
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if($form->isSubmitted())
        {
            $this->addFlash('success', 'Post został utworzony');
            $em = $this->getDoctrine()->getManager();

            /** @var UploadedFile $file */
            $file = $request->files->get('post')['photo'];
            if($file)
            {
                $filename = md5(uniqid()) . '.' . $file->guessClientExtension();
                $file->move(
                    $this->getParameter('uploads_dir'),
                    $filename
                );
                $post->setPhoto($filename);
            }


            $em->persist($post);
            $em->flush();

            return $this->redirect($this->generateUrl('main'));
        }

        return $this->render('post/index.html.twig',[
            'form' => $form->createView()
        ]);
        //return $this->redirect($this->generateUrl('main'));

    }

    /**
     * @Route("/delete/{id}", name="delete")
     * @param Post $post
     */
    public function delete($id, PostRepository $postRepository)
    {
        $post = $postRepository->find($id);
        $em = $this->getDoctrine()->getManager();

        $em->remove($post);
        $em->flush();

        $this->addFlash('success', 'Post został usunięty');

        return $this->redirect($this->generateUrl('main'));
    }

}
