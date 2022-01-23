<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Repository\LivreRepository;
use App\Repository\AutheurRepository;
use App\Repository\GenreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;



class PanneauController extends AbstractController
{
    /**
     * @Route("/Dashboard", name="dashboard_index", methods={"GET"})
     */
        public function index( UserRepository $ur,GenreRepository $gr,AutheurRepository $ar,LivreRepository $lr ): Response
    {
        $users=$ur->findAll();
        $users=count($users);
        $livres=count($lr->findAll());
        $autheurs=count($ar->findAll());
        $genres=count($gr->findAll());
        return $this->render('user/dashboard.html.twig', [
            'users' => $users,
            'livres' => $livres,
            'genres' => $genres,
            'autheurs' => $autheurs,
            
        ]);
    }

  
}
