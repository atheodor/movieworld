<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\Vote;
use App\Form\MovieFormType;
use App\Repository\MovieRepository;
use App\Repository\UserRepository;
use App\Repository\VoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    private $movieRepository;
    private $userRepository;
    private $voteRepository;

    public function __construct(MovieRepository $movieRepository, UserRepository $userRepository, VoteRepository $voteRepository)
    {
        $this->movieRepository = $movieRepository;
        $this->userRepository = $userRepository;
        $this->voteRepository = $voteRepository;
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
        if ($form->isSubmitted() && $form->isValid()) {
            $newMovie = $form->getData();
            $user = $this->getUser();
            $newMovie->setAddedBy($user);
            $this->movieRepository->add($newMovie, true);
            return $this->redirectToRoute('index');
        }

        return $this->render('movies/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/{id}", name="user_movies")
     */
    public function userMovies($id): Response
    {
        $movies = $this->movieRepository->findBy(array('added_by' => $id), array('date_published' => 'DESC'));
        $user = $this->userRepository->findOneBy(array('id' => $id), array());
        return $this->render('home/index.html.twig', [
            'movies' => $movies,
            'filtered_user' => $user->getName()
        ]);
    }

    /**
     * @Route("/vote-positive/{movie_id}", name="vote_positive")
     */
    public function votePositive($movie_id): Response
    {
        $user = $this->getUser();
        $movie = $this->movieRepository->findOneBy(array('id' => $movie_id), array());

        if ($user && $movie && $movie->getAddedBy() != $user) {
            $vote = $this->voteRepository->findOneBy(array('movie' => $movie, 'user' => $user), array());
            if (!$vote) {
                $vote = new Vote();
                $vote->setUser($user);
                $vote->setMovie($movie);
            } elseif ($vote->getPositive() == true) {
                try {
                    $this->voteRepository->remove($vote);
                } catch (\Exception $e) {
                    return $this->redirectToRoute('index');
                }
            }
            $vote->setPositive(true);
            try {
                $this->voteRepository->add($vote, true);
            } catch (\Exception $e) {
                return $this->redirectToRoute('index');
            }
        }

        return $this->redirectToRoute('index');
    }

    /**
     * @Route("/vote-negative/{movie_id}", name="vote_negative")
     */
    public function voteNegative($movie_id): Response
    {
        $user = $this->getUser();
        $movie = $this->movieRepository->findOneBy(array('id' => $movie_id), array());

        if ($user && $movie && $movie->getAddedBy() != $user) {
            $vote = $this->voteRepository->findOneBy(array('movie' => $movie, 'user' => $user), array());
            if (!$vote) {
                $vote = new Vote();
                $vote->setUser($user);
                $vote->setMovie($movie);
            } elseif ($vote->getPositive() == false) {
                try {
                    $this->voteRepository->remove($vote);
                } catch (\Exception $e) {
                    return $this->redirectToRoute('index');
                }
            }
            $vote->setPositive(false);
            try {
                $this->voteRepository->add($vote, true);
            } catch (\Exception $e) {
                return $this->redirectToRoute('index');
            }
        }

        return $this->redirectToRoute('index');
    }
}
