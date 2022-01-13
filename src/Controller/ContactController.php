<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request): Response
    {

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if($form->isSubmitted()){

        $data = $form->getData();
        $email = $data['email'];
        $contenu = $data['contenu'];

            return $this->render('contact/contactSub.html.twig', [
            'mail' => $email,
            'contenu' => $contenu
            ]);

        }else{

            return $this->renderForm('contact/index.html.twig', [
            'formCon' => $form,
            ]);

        }


        
    }
}
