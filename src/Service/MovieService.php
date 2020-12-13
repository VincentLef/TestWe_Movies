<?php

namespace App\Service;

use App\Entity\Movie;
use Doctrine\ORM\EntityManagerInterface;

class MovieService
{
    /** @var EntityManagerInterface */
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function saveMovie(Movie $movie) {
        $this->em->persist($movie);
        $this->em->flush();
    }

    public function deleteMovie(Movie $movie) {
        $this->em->remove($movie);
        $this->em->flush();
    }

    public function getAllMovies() {
        return $this->getMovieRepository()->findAll();
    }

    public function getMovieRepository() {
        return $this->em->getRepository(Movie::class);
    }
}