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
        /** @var mixed $options */
        $options = json_decode($request->getContent(), true);

        $randomGenerator = new RandomnessGenerator(
            $options['min'],
            $options['max'],
            $options['format'],
            $options['seed'],
            $options['mode'],
            $options['devOptions']
        );

        return $this->json($randomGenerator->generate());
    }
}