<?php

namespace App\Controller;

use App\Form\MovieFormType;
use App\Entity\Movie;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
            'movies' => $movies
        ]);
    }

    /**
     * @Route("/add-movie", name="add_movie")
     */
    public function addMovie(Request $request): Response
    {
        $movie = new Movie();
        $form = $this->createForm(MovieFormType::class, $movie);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $newMovie = $form->getData();
            $user = $this->getUser();
            $newMovie->setAddedBy($user);
            $this->movieRepository->add($newMovie, true);
            return $this->redirectToRoute('index');
        }

        return $this->render('movies/create.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
