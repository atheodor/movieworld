<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $movieRepository;

    public function __construct(MovieRepository $movieRepository){
        $this->movieRepository = $movieRepository;
    }

    /**
     * @Route("/home", name="app_home")
     */
    public function index(): Response
    {
        $movies = $this->movieRepository->findBy(array(), array('date_published' => 'DESC'));
        return $this->render('home/index.html.twig', [
            'movie_count' => sizeof($movies),
            'movies' => $movies
        ]);
    }
}
