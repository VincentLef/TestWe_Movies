<?php

namespace App\Controller;

use App\Service\ShowingService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/showing")
 *
 * Class ShowingController
 * @package App\Controller
 */
class ShowingController extends AbstractController
{
    /**
     * @Route("/", name="listShowing")
     * @Template("Showing/index.html.twig")
     * @param ShowingService $showingService
     * @return array
     */
    public function index(ShowingService $showingService): array
    {
        $showings = $showingService->getAllShowings();
        return ["showings" => $showings];
    }
}
