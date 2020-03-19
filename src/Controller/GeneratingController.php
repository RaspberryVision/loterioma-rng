<?php
/**
 * Generating Controller class.
 *
 * ~
 *
 * @category   Controllers
 * @package    App\Controller
 * @author     Rafal Malik <kontakt@raspberryvision.pl>
 * @copyright  03.2020 Raspberry Vision
 */

namespace App\Controller;

use App\Generator\RandomnessGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GeneratingController extends AbstractController
{
    /**
     * @Route("/generate", name="app_generate")
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $randomGenerator = new RandomnessGenerator(
            $request->get('seed'),
            [
                $request->get('range')['min'],
                $request->get('range')['max']
            ],
            $request->get('matrix')
        );

        return $this->json($randomGenerator->generate());
    }
}
