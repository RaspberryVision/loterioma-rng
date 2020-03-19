<?php
/**
 * RandomnessGenerableInterface interface.
 *
 * Interface ensuring basic operations of the random value generator.
 *
 * @category   Generators
 * @package    App\Generator
 * @author     Rafal Malik <kontakt@raspberryvision.pl>
 * @copyright  03.2020 Raspberry Vision
 */

namespace App\Generator;

interface RandomnessGenerableInterface
{
    /**
     * The method which for all fields of the matrix draws numerical values
     * from the range and saves them in the resulting matrix.
     *
     * @return bool
     */
    public function generate(): bool;

    /**
     * Return the generator matrix in array format.
     *
     * @return array
     */
    public function getMatrix(): array;

    /**
     * Return the range from which the numbers are drawn.
     *
     * @return array
     */
    public function getRange(): array;

    /**
     * Returns the minimum value for a random range.
     *
     * @return int
     */
    public function getMin(): int;

    /**
     * Returns the max value for a random range.
     *
     * @return int
     */
    public function getMax(): int;

    /**
     * Return the generator scoreboard, all randomly drawn numbers are entered on it.
     *
     * @return array
     */
    public function getResultMatrix(): array;

    /**
     *
     *
     * @return int
     */
    public function getSeed(): int;

    /**
     * @return int
     */
    public function getCurrentState(): int;

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
    public function init(int $seed = 0, int $state = 0): bool;
}