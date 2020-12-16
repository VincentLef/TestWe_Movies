<?php


namespace App\Controller;


use App\Entity\Person;
use App\Form\PersonType;
use App\Service\PersonService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("person")
 *
 * Class PersonController
 * @package App\Controller
 */
class PersonController extends AbstractController
{
    /**
     * @Route("/", name="listPerson")
     * @Template("person/index.html.twig")
     *
     * @param PersonService $personService
     * @return array
     */
    public function index(PersonService $personService)
    {
        $people = $personService->findAllPeople();

        return ['people' => $people];
    }

    /**
     * @Route("/list/page/{page}", name="listPersonFromPage", requirements={"page"="\d+"})
     * @Template("Person/index.html.twig")
     * @param PersonService $personService
     * @param int $page
     * @return array
     */
    public function listFromPage(PersonService $personService, int $page): array
    {
        $people = $personService->getPeopleFromPage($page);
        return ["people" => $people];
    }

    /**
     * @Route("/list/page/{page}/limit/{limit}", name="listPersonFromPageAndLimit", requirements={"page"="\d+", "limit"="\d+"})
     * @Template("Person/index.html.twig")
     * @param PersonService $personService
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function listFromPageAndLimit(PersonService $personService, int $page, int $limit): array
    {
        $people = $personService->getPeopleFromPage($page, $limit);
        return ["people" => $people];
    }

    /**
     * @Route("/new", name="newPerson")
     *
     * @param PersonService $personService
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function new(PersonService $personService, Request $request)
    {
        $person = new Person();
        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $personService->savePerson($person);
            return $this->redirectToRoute('listPerson');
        }

        return $this->render('person/edit.html.twig', ['form_person' => $form->createView()]);
    }

    /**
     * @Route("/edit/{person}", name="editPerson")
     *
     * @param PersonService $personService
     * @param Person $person
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function edit(PersonService $personService, Person $person, Request $request)
    {
        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $personService->savePerson($person);
            return $this->redirectToRoute('listPerson');
        }

        return $this->render('person/edit.html.twig', ['form_person' => $form->createView()]);
    }

    /**
     * @Route("/movies/{person}", name="moviesPerson")
     * @Template("movie/index.html.twig")
     *
     * @param PersonService $personService
     * @param Person $person
     * @return array
     */
    public function showMovies(PersonService $personService, Person $person)
    {
        $movies = $personService->getMoviesOf($person);

        return ['movies' => $movies];
    }
}