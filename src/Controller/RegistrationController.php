<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\User;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/registration", name="registration")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registration(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $form = $this->createFormBuilder()
            ->add('nick')
            ->add('password', RepeatedType::class,[
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Haslo'],
                'second_options' => ['label' => 'Powtorz haslo'],
            ])
            ->add('Rejestracja', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success float-right'
                ]
            ])
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted())
        {
            $data = $form->getData();

            $user = new \App\Entity\User();
            $user->setUsername($data['nick']);
            $user->setPassword(
                $passwordEncoder->encodePassword($user, $data['password'])
            );

            $this->addFlash('success', 'Poprawne zalogowanie');
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('app_login'));
        }

        return $this->render('registration/index.html.twig', [
            'form' =>$form->createView()
        ]);
    }
}
