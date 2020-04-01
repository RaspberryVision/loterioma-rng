<?php
/**
 * RandomnessGenerator class.
 *
 * Ss responsible for pseudo-random generation of numbers from the given range,
 * in the given format. All symbols are represented by integers, the game table
 * is represented by a matrix.
 *
 * @category   Generators
 * @package    App\Generator
 * @author     Rafal Malik <kontakt@raspberryvision.pl>
 * @copyright  03.2020 Raspberry Vision
 */

namespace App\Generator;

use App\Exception\InvalidGeneratorRangeException;

class RandomnessGenerator implements RandomnessGenerableInterface
{
    const MODE_LIVE = 0;
    const MODE_TEST = 1;
    const MODE_DEBUG = 2;

    /**
     * @var int Number represents current state in history of generator.
     */
    private $currentState;

    /**
     * @var int Number used to generate random numbers.
     */
    private $seed;

    /**
     * @var array $min Min number.
     */
    private $min;

    /**
     * @var array $max Max number.
     */
    private $max;

    /**
     * @var $format
     */
    private $format;

    /**
     * @var int $mode
     */
    private $mode;

    /**
     * @var array $devOptions
     */
    private $devOptions;

    /**
     * @var array Result matrix, after generating the results are saved here.
     */
    private $result;

    /**
     * RandomnessGenerator constructor.
     * @param int $min
     * @param int $max
     * @param array $format
     * @param int $seed
     * @param int $mode
     * @param array $devOptions
     */
    public function __construct(
        int $min,
        int $max,
        array $format,
        int $seed = 0,
        int $mode = self::MODE_LIVE,
        array $devOptions = []
    )
    {
        $this->init($seed, 0);
        $this->min = $min;
        $this->max = $max;
        $this->format = $format;
        $this->mode = $mode;
        $this->devOptions = $devOptions;
    }

    /**
     * The method which for all fields of the matrix draws numerical values
     * from the range and saves them in the resulting matrix.
     *
     * @return array
     */
    public function generate(): array
    {
        foreach ($this->format as $indexY => $row) {

            foreach ($row as $indexX => $field) {
                $this->result[$indexY][$indexX] = rand($this->getMin(), $this->getMax());
            }
        }

        return $this->result;
    }

    /**
     * Returns the minimum value for a random range.
     *
     * @return int
     */
    public function getMin(): int
    {
        return $this->min;
    }

    /**
     * Returns the max value for a random range.
     *
     * @return int
     */
    public function getMax(): int
    {
        return $this->max;
    }

    /**
     *
     *
     * @return int
     */
    public function getSeed(): int
    {
        return $this->seed;
    }

    /**
     * @return int
     */
    public function getCurrentState(): int
    {
        return $this->currentState;
    }

    /**
     * Initialize generator with specific $seed and $state.
     * Return true if successfully set generator values, otherwise
     * return false.
     *
     * This function can be used for reset generator to factory
     * condition (when state and seed equals 0).
     *
     * @param int $seed
     * @param int $state
     * @return bool
     */
    public function init(?int $seed = 0, ?int $state = 0): bool
    {
        $this->seed = $seed;
        $this->currentState = $state;

        return true;
    }

    /**
     * Return the value for a specific field of the result matrix.
     *
     * @param int $indexX
     * @param int $indexY
     * @return int
     */
    public function getValue(int $indexX, int $indexY): int
    {
        if (isset($this->result[$indexX][$indexY])) {
            return $this->result[$indexX][$indexY];
        }

        return -1;
    }

    /**
     * @return array
     */
    public function getFormat(): array
    {
        return $this->format;
    }

    /**
     * @return array
     */
    public function getResult(): array
    {
        return $this->result;
    }
}