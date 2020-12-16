<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Service\MovieService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/movie")
 *
 * Class MovieController
 * @package App\Controller
 */
class MovieController extends AbstractController
{
    /**
     * @Route("/", name="listMovie")
     * @Template("Movie/index.html.twig")
     * @param MovieService $movieService
     * @return array
     */
    public function index(MovieService $movieService): array
    {
        $movies = $movieService->getAllMovies();

        return ["movies" => $movies];
    }

    /**
     * @Route("/list/page/{page}", name="listMovieFromPage", requirements={"page"="\d+"})
     * @Template("Movie/index.html.twig")
     * @param MovieService $movieService
     * @param int $page
     * @return array
     */
    public function listFromPage(MovieService  $movieService, int $page): array
    {
        $movies = $movieService->getMoviesFromPage($page);
        return ["movies" => $movies];
    }

    /**
     * @Route("/list/page/{page}/limit/{limit}", name="listMovieFromPageAndLimit", requirements={"page"="\d+", "limit"="\d+"})
     * @Template("Movie/index.html.twig")
     * @param MovieService $movieService
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function listFromPageAndLimit(MovieService  $movieService, int $page, int $limit): array
    {
        $movies = $movieService->getMoviesFromPage($page, $limit);
        return ["movies" => $movies];
    }

    /**
     * @Route("/new", name="newMovie")
     * @param MovieService $movieService
     * @param Request $request
     * @return Response
     */
    public function new(MovieService $movieService, Request $request): Response
    {
        $movie = new Movie();
        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $movieService->saveMovie($movie);
            return $this->redirectToRoute('listMovie');
        }

        return $this->render('movie/edit.html.twig', ['form_movie' => $form->createView()]);
    }

    /**
     * @Route("/edit/{movie}", name="editMovie")
     * @param Movie $movie
     * @param Request $request
     * @param MovieService $movieService
     * @return Response
     */
    public function edit(Movie $movie, Request $request, MovieService $movieService): Response
    {
        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $movieService->saveMovie($movie);
            return $this->redirectToRoute('listMovie');
        }

        return $this->render('movie/edit.html.twig', ['form_movie' => $form->createView()]);
    }
}
