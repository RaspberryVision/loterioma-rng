<?php

namespace App\DTO;

class GeneratorConfig
{
    /**
     * @var int
     */
    private $seed;

    /**
     * @var int
     */
    private $min;

    /**
     * @var int
     */
    private $max;

    /**
     * @var array
     */
    private $format;

    /**
     * Developer can to debug RNG by change this value to DEBUG.
     *
     * @var string
     */
    private $mode = 'DEV';

    /**
     * If DEBUG mode is enabled, we can to add parameters to RNG:
     * - response,
     *
     * @var array
     */
    private $devOptions;
}