<?php

namespace App\Logger;

use Psr\Log\LoggerInterface;

class GeneratorLogger
{
    private $logger;

    /**
     * GeneratorLogger constructor.
     * @param $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


}