<?php

namespace App\Controller;

use App\Form\AgeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\DateTime;

class AccueilController extends AbstractController
{
    /**
     * @Route("/accueil", name="accueil")
     */
    public function index(Request $request): Response
    {

       

        $form = $this->createForm(AgeType::class);
        $form->handleRequest($request);

        if($form->isSubmitted()){

            $data = $form->getData();
            $nom = $data['nomPersonne'];
            $age = $data['agePersonne'];

            $datetime1 =  new \DateTime(); // date actuelle

            $cal = $datetime1->diff($age, true)->y;
            

            

            return $this->render('accueil/calculage.html.twig', [
                'nom' => $nom,
                'age' => $age,
                'calc' => $cal
            ]); 


        }else{

           return $this->renderForm('accueil/index.html.twig', [
            'formAge' => $form,
        ]); 

        }

        
    }
}
