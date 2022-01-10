<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Form\LivreType;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/livre")
 */
class LivreController extends AbstractController
{
    /**
     * @Route("/", name="livre_index", methods={"GET"})
     */
    public function index(LivreRepository $livreRepository): Response
    {
        return $this->render('livre/index.html.twig', [
            'livres' => $livreRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="livre_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $livre = new Livre();
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($livre);
            $entityManager->flush();

            return $this->redirectToRoute('livre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('livre/new.html.twig', [
            'livre' => $livre,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="livre_show", methods={"GET"})
     */
    public function show(Livre $livre): Response
    {
        return $this->render('livre/show.html.twig', [
            'livre' => $livre,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="livre_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Livre $livre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('livre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('livre/edit.html.twig', [
            'livre' => $livre,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="livre_delete", methods={"POST"})
     */
    public function delete(Request $request, Livre $livre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$livre->getId(), $request->request->get('_token'))) {
            $entityManager->remove($livre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('livre_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("chercher/{motCle}", name="livre_chercher", methods={"GET"})
     */
    public function chercher(String $motCle,LivreRepository $livreRepository,GenreRepository $genreRepository,AutheurRepsitory $autheurRepository):Response{
      $livres=$livreRepository->getLivreByTitre($motCle);
        return $this.render('livre/chercher.twig.html',['livres'=>$livres,'genres'=>$genreRepository->getAll(),'autheurs'=>$autheurRepository->getAll()]);
    }
    /**
     * @Route("chercher/entre_dates/{dateMin}/{dateMax}", name="livre_entreDates", methods={"GET"})
     */
    public function chercherByDates( $dateMin, $dateMax,LivreRepository $livreRepository,GenreRepository $genreRepository,AutheurRepsitory $autheurRepository):Response{
        $livres=$livreRepository->getLivreBetweenTwoDates(strval($dateMin),strval($dateMax));
          return $this.render('livre/chercher.twig.html',['livres'=>$livres,'genres'=>$genreRepository->getAll(),'autheurs'=>$autheurRepository->getAll()]);
      }

      /**
     * @Route("chercher/livresParNote/{note}", name="livre_parNote", methods={"GET"})
     */
    public function findByNote( $note, LivreRepository $livreRepository):Response{
        $livres=$livreRepository->getLivresByNote($note);
          return $this.render('livre/chercher.twig.html',['livres'=>$livres]);
      }
        /**
     * @Route("chercher/livresParGenre/{genre}", name="livre_parGenre", methods={"GET"})
     */
    public function findByGenre( $genre, LivreRepository $livreRepository):Response{
        $livres=$livreRepository->getLivresByGenre($genre);
          return $this.render('livre/chercher.twig.html',['livres'=>$livres]);
      }

       /**
     * @Route("chercher/livresParAutheur/{autheur}", name="livre_parAutheur", methods={"GET"})
     */
    public function findByAutheur( $genre, LivreRepository $livreRepository):Response{
        $livres=$livreRepository->getLivresByAutheur($autheur);
          return $this.render('livre/chercher.twig.html',['livres'=>$livres]);
      }

       /**
     * @Route("chercher/dates", name="livre_parAutheur", methods={"GET"})
     */
    public function findDates(LivreRepository $livreRepository):Response{
        $livres=$livreRepository->getDates($autheur);
          return $this.render('livre/chercher.twig.html',['livres'=>$livres]);
      }
}
