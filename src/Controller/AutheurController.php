<?php

namespace App\Controller;

use App\Entity\Autheur;
use App\Form\AutheurType;
use App\Repository\AutheurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/autheur")
 */
class AutheurController extends AbstractController
{
    /**
     * @Route("/", name="autheur_index", methods={"GET"})
     */
    public function index(AutheurRepository $autheurRepository): Response
    {
        return $this->render('autheur/index.html.twig', [
            'autheurs' => $autheurRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="autheur_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $autheur = new Autheur();
        $form = $this->createForm(AutheurType::class, $autheur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($autheur);
            $entityManager->flush();

            return $this->redirectToRoute('autheur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('autheur/new.html.twig', [
            'autheur' => $autheur,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="autheur_show", methods={"GET"})
     */
    public function show(Autheur $autheur): Response
    {
        return $this->render('autheur/show.html.twig', [
            'autheur' => $autheur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="autheur_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Autheur $autheur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AutheurType::class, $autheur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('autheur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('autheur/edit.html.twig', [
            'autheur' => $autheur,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="autheur_delete", methods={"POST"})
     */
    public function delete(Request $request, Autheur $autheur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$autheur->getId(), $request->request->get('_token'))) {
            $entityManager->remove($autheur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('autheur_index', [], Response::HTTP_SEE_OTHER);
    }
}
