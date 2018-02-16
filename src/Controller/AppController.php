<?php

namespace App\Controller;

use App\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class AppController extends Controller
{
    /**
     * @Route("/", name="app")
     */
    public function editAction(Request $request, UserInterface $user)
    {
        // 1) build the form
        $form = $this->createForm(UserType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            $this->addFlash('success', 'success');
        } else {
            $this->addFlash('error', 'error');
        }

        return $this->render(
            'edit.html.twig',
            array('form' => $form->createView())
        );
    }
}
