<?php

namespace App\Service;

use App\Entity\Showing;
use Doctrine\ORM\EntityManagerInterface;

class ShowingService
{
    /** @var EntityManagerInterface */
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getAllShowings() {
        return $this->getShowingRepository()->findAll();
    }

    public function getShowingRepository() {
        return $this->em->getRepository(Showing::class);
    }
}