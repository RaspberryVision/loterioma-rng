<?php

namespace App\Controller;

use App\Generator\RandomnessGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EndpointController extends AbstractController
{
    /**
     * @Route("/random", name="web_endpoint_random")
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function random(Request $request)
    {
        /** @var array $options */
        $options = json_decode($request->getContent(), true);

        $randomGenerator = new RandomnessGenerator(
            $options['min'],
            $options['max'],
            $options['format'],
            $options['seed']
        );

        return $this->json($randomGenerator->generate());
    }
}
