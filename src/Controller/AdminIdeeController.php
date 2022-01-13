<?php

namespace App\Controller;

use App\Entity\Idee;
use App\Form\IdeeType;
use App\Repository\IdeeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/idee")
 */
class AdminIdeeController extends AbstractController
{
    /**
     * @Route("/", name="admin_idee_index", methods={"GET"})
     */
    public function index(IdeeRepository $ideeRepository): Response
    {
        return $this->render('admin_idee/index.html.twig', [
            'idees' => $ideeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_idee_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $idee = new Idee();
        $form = $this->createForm(IdeeType::class, $idee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($idee);
            $entityManager->flush();

            return $this->redirectToRoute('admin_idee_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_idee/new.html.twig', [
            'idee' => $idee,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_idee_show", methods={"GET"})
     */
    public function show(Idee $idee): Response
    {
        return $this->render('admin_idee/show.html.twig', [
            'idee' => $idee,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_idee_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Idee $idee, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(IdeeType::class, $idee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_idee_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_idee/edit.html.twig', [
            'idee' => $idee,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_idee_delete", methods={"POST"})
     */
    public function delete(Request $request, Idee $idee, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$idee->getId(), $request->request->get('_token'))) {
            $entityManager->remove($idee);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_idee_index', [], Response::HTTP_SEE_OTHER);
    }
}
