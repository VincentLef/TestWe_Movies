<?php


namespace App\Service;


use App\Entity\Movie;
use App\Entity\Person;
use Doctrine\ORM\EntityManagerInterface;

class PersonService
{
    /** @var EntityManagerInterface */
    protected $em;

    const NB_PEOPLE_PER_PAGE = 10;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return array|Person[]
     */
    public function findAllPeople(): array
    {
        return $this->em->getRepository(Person::class)->findAll();
    }

    public function getPeopleFromPage(int $page, int $limit = self::NB_PEOPLE_PER_PAGE)
    {
        if ($page === 0) {
            $page = 1;
        }
        $offset = $limit * ($page - 1);
        return $this->em->getRepository(Person::class)->findBy([], [], $limit, $offset);
    }

    /**
     * @param Person $person
     * @return Person[]
     */
    public function getMoviesOf(Person $person): array
    {
        return $this->em->getRepository(Movie::class)->getMoviesOf($person);
    }

    /**
     * @param Person $person
     */
    public function savePerson(Person $person)
    {
        $this->em->persist($person);
        $this->em->flush();
    }
}