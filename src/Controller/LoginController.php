<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    /**
     * @Route("/logi", name="logi")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
        $user = new User();

        $form = $this->createForm(PostType::class, $user);



        $form->handleRequest($request);

        if($form->isSubmitted())
        {
            $this->addFlash('success', 'Post został utworzony');
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirect($this->generateUrl('main'));
        }

        return $this->render('post/index.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
