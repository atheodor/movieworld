<?php

namespace App\Controller;

use App\Form\MovieFormType;
use App\Entity\Movie;
use App\Repository\MovieRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $movieRepository;
    private $userRepository;

    public function __construct(MovieRepository $movieRepository, UserRepository $userRepository){
        $this->movieRepository = $movieRepository;
        $this->userRepository = $userRepository;
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

    /**
     * @Route("/user/{id}", name="user_movies")
     */
    public function userMovies($id): Response
    {
        $movies = $this->movieRepository->findBy(array('added_by' => $id), array('date_published' => 'DESC'));
        $user = $this->userRepository->findOneBy(array('id' => $id),array());
        return $this->render('home/index.html.twig', [
            'movies' => $movies,
            'filtered_user' => $user->getName()
        ]);
    }
}
