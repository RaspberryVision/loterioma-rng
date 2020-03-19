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
    /**
     * @var int Number represents current state in history of generator.
     */
    private $currentState;

    /**
     * @var int Number used to generate random numbers.
     */
    private $seed;

    /**
     * @var array An array with a range of random numbers.
     */
    private $range;

    /**
     * @var array Matrix for the draw.
     */
    private $matrix;

    /**
     * @var array Result matrix, after generating the results are saved here.
     */
    private $resultMatrix;

    /**
     * RandomnessGenerator constructor.
     * @param int $seed
     * @param array $range
     * @param array $matrix
     */
    public function __construct(int $seed, array $range, array $matrix)
    {
        $this->init($seed, 0);
        $this->range = $range;
        $this->matrix = $matrix;
        $this->resultMatrix = $matrix;
    }

    /**
     * The method which for all fields of the matrix draws numerical values
     * from the range and saves them in the resulting matrix.
     *
     * @return array
     */
    public function generate(): array
    {
        foreach ($this->matrix as $indexY => $row) {

            foreach ($row as $indexX => $field) {
                $this->resultMatrix[$indexY][$indexX] = rand($this->getMin(), $this->getMax());
            }
        }

        return $this->resultMatrix;
    }

    /**
     * Return the generator matrix in array format.
     *
     * @return array
     */
    public function getMatrix(): array
    {
        return $this->matrix;
    }

    /**
     * Return the range from which the numbers are drawn.
     *
     * @return array
     */
    public function getRange(): array
    {
        return $this->range;
    }

    /**
     * Returns the minimum value for a random range.
     *
     * @return int
     */
    public function getMin(): int
    {
        if (2 !== count($this->range)) {
            throw new InvalidGeneratorRangeException("The generator compartment is not valid.");
        }

        return $this->range[0];
    }

    /**
     * Returns the max value for a random range.
     *
     * @return int
     */
    public function getMax(): int
    {
        if (2 !== count($this->range)) {
            throw new InvalidGeneratorRangeException("The generator compartment is not valid.");
        }

        return $this->range[1];
    }

    /**
     * Return the generator scoreboard, all randomly drawn numbers are entered on it.
     *
     * @return array
     */
    public function getResultMatrix(): array
    {
        return $this->resultMatrix;
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
        if (isset($this->resultMatrix[$indexX][$indexY])) {
            return $this->resultMatrix[$indexX][$indexY];
        }

        return -1;
    }
}