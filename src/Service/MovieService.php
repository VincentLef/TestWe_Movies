<?php

namespace App\Service;

use App\Entity\Movie;
use Doctrine\ORM\EntityManagerInterface;

class MovieService
{
    /** @var EntityManagerInterface */
    protected $em;

    const NB_MOVIES_PER_PAGE = 10;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function saveMovie(Movie $movie) {
        $this->em->persist($movie);
        $this->em->flush();
    }

    public function getAllMovies() {
        return $this->getMovieRepository()->findAll();
    }

    public function getMoviesFromPage(int $page)
    {
        if ($page === 0) {
            $page = 1;
        }
        $offset = self::NB_MOVIES_PER_PAGE * ($page - 1);
        return $this->getMovieRepository()->findBy([], [], self::NB_MOVIES_PER_PAGE, $offset);
    }

    public function getMovieRepository() {
        return $this->em->getRepository(Movie::class);
    }
}