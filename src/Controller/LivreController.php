<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Form\LivreType;
use App\Repository\LivreRepository;
use App\Repository\GenreRepository;
use App\Repository\AutheurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/")
 */
class LivreController extends AbstractController
{

    /**
     * @Route("/", name="livre_index", methods={"GET"})
     */
    public function index(Request $request,LivreRepository $livreRepository,AutheurRepository $ar,GenreRepository $gr,PaginatorInterface $paginator): Response
    {
        $livres=$livreRepository->findAll();
        $livres = $paginator->paginate(
            $livres, 
            $request->query->getInt('page', 1),
            8/*limit per page*/
        );
        return $this->render('livre/index.html.twig', [
            'livres' => $livres,
            'autheurs' => $ar->findAll(),
            'genres' => $gr->findAll(),

        ]);
    }

    /**
     * @Route("livre/new", name="livre_new", methods={"GET", "POST"})
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
     * @Route("livre/{id}", name="livre_show", methods={"GET"})
     */
    public function show(Livre $livre): Response
    {
        return $this->render('livre/show.html.twig', [
            'livre' => $livre,
        ]);
    }

    /**
     * @Route("livre/{id}/edit", name="livre_edit", methods={"GET", "POST"})
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
     * @Route("livre/{id}", name="livre_delete", methods={"POST"})
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
     * @Route("livre/chercher/{motCle}", name="livre_chercher", methods={"GET"})
     */
    public function chercher(Request $request,String $motCle,LivreRepository $lr,PaginatorInterface $paginator,GenreRepository $gr,AutheurRepository $ar):Response{
      $livres=$lr->findByTitre($motCle);
      $livres = $paginator->paginate(
        $livres, 
        $request->query->getInt('page', 1),
        8/*limit per page*/
    );
        return $this->render('livre/chercher.html.twig',['livres'=>$livres,
        //'genres'=>$gr->getAll(),'autheurs'=>$ar->getAll()
    ]);
    }
    /**
     * @Route("livre/chercher/entre_dates/{dateMin}/{dateMax}", name="livre_entreDates", methods={"GET"})
     */
    public function findByDates( Request $request,$dateMin, $dateMax,LivreRepository $lr,GenreRepository $gr,PaginatorInterface $paginator,AutheurRepository $ar):Response{
        $livres=$lr->findBetweenTwoDates(strval($dateMin),strval($dateMax));
        $livres = $paginator->paginate(
            $livres, 
            $request->query->getInt('page', 1),
            8/*limit per page*/
        );
          return $this->render('livre/chercher.html.twig',['livres'=>$livres,
          //'genres'=>$genreRepository->getAll(),'autheurs'=>$autheurRepository->getAll()
        ]);
      }

      /**
     * @Route("livre/chercher/livresParNote/{note}", name="livre_parNote", methods={"GET"})
     */
    public function findByNote(Request $request, $note, LivreRepository $livreRepository,PaginatorInterface $paginator):Response{
        $livres=$livreRepository->findByNote($note);
        $livres = $paginator->paginate(
            $livres, 
            $request->query->getInt('page', 1),
            8/*limit per page*/
        );
          return $this->render('livre/chercher.html.twig',['livres'=>$livres]);
      }
        /**
     * @Route("livre/chercher/livresParGenre/{id}", name="livre_parGenre", methods={"GET"})
     */
    public function findByGenre(Request $request, $id, LivreRepository $livreRepository,PaginatorInterface $paginator):Response{
        $livres=$livreRepository->findByGenre($id);
          return $this->render('livre/chercher.html.twig',['livres'=>$livres]);
      }

       /**
     * @Route("livre/chercher/livresParAutheur/{id}", name="livre_parAutheur", methods={"GET"})
     */
    public function findByAutheur(Request $request, $id, LivreRepository $livreRepository,PaginatorInterface $paginator):Response{
        $livres=$livreRepository->findByAutheur($id);
        $livres = $paginator->paginate(
            $livres, 
            $request->query->getInt('page', 1),
            8/*limit per page*/
        );
          return $this->render('livre/chercher.html.twig',['livres'=>$livres]);
      }
      /**
     * @Route("livre/chercher/livresParDate/{date}", name="livreParDate", methods={"GET"})
     */
    public function findByDate(Request $request, $date, LivreRepository $livreRepository,PaginatorInterface $paginator):Response{
        $livres=$livreRepository->findByDate($date);
        $livres = $paginator->paginate(
            $livres, 
            $request->query->getInt('page', 1),
            8/*limit per page*/
        );
          return $this->render('livre/chercher.html.twig',['livres'=>$livres]);
      }

       /**
     * @Route("livre/chercher/dates", name="livre_dates", methods={"GET"})
     */
    public function findDates(Request $request,LivreRepository $livreRepository,PaginatorInterface $paginator):Response{
        $livres=$livreRepository->findDates();
        $livres = $paginator->paginate(
            $livres, 
            $request->query->getInt('page', 1),
            8/*limit per page*/
        );
          return $this->render('livre/chercher.html.twig',['livres'=>$livres]);
      }
}
