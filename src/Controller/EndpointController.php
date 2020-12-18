<?php

namespace App\Controller;

use App\Generator\RandomGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EndpointController extends AbstractController
{
    /**
     * @Route("/", name="web_endpoint_index")
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function index(Request $request)
    {
        return $this->json(['RNG App']);
    }

    /**
     * @Route("/generate", name="web_endpoint_generate")
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function generate(Request $request)
    {
        /** @var array $options */
        $options = json_decode($request->getContent(), true);

        $randomGenerator = new RandomGenerator(
            $options['min'],
            $options['max'],
            $options['format'],
            $options['seed'],
            $options['result'] ?? []
        );

        if ($randomGenerator->getResult()) {
            return $this->json($randomGenerator->getResult());
        }

        return $this->json($randomGenerator->generate());
    }
}
