<?php

/**
 * Unit testing for RandomnessGenerator class.
 *
 * ~
 *
 * @category   UnitTests
 * @package    App\Tests\Generator
 * @author     Rafal Malik <kontakt@raspberryvision.pl>
 * @copyright  03.2020 Raspberry Vision
 */

namespace App\Tests\Generator;

use App\Generator\RandomGeneratorInterface;
use PHPUnit\Framework\TestCase;
use App\Generator\RandomGenerator;

class RandomGeneratorTest extends TestCase
{
    /**
     * Check that RandomGenerator class implement RandomGeneratorInterface.
     *
     * @dataProvider dataProviderCreateInstance
     * @param array $testCase
     */
    public function testDoesImplementRandomGeneratorInterface(array $testCase)
    {
        $randomGenerator = $this->createGenerator($testCase);

        $this->assertInstanceOf(RandomGeneratorInterface::class, $randomGenerator);
    }

    /**
     * Test that create new instance by constructor correctly sets field values.
     *
     * @dataProvider dataProviderCreateInstance
     * @param array $testCase
     */
    public function testCreateInstance(array $testCase)
    {
        $randomnessGenerator = $this->createGenerator(
            $testCase
        );

        $this->assertEquals($testCase['seed'], $randomnessGenerator->getSeed());
        $this->assertEquals($testCase['min'], $randomnessGenerator->getMin());
        $this->assertEquals($testCase['max'], $randomnessGenerator->getMax());
        $this->assertEquals($testCase['format'], $randomnessGenerator->getFormat());
    }

    /**
     * Data provider for testCreateInstance.
     *
     * @return \Generator
     */
    public function dataProviderCreateInstance()
    {
        yield [
            [
                'seed' => 0,
                'min' => 0,
                'max' => 10,
                'format' => [
                    [-1, -1],
                    [-1, -1],
                ],
            ],
        ];
    }

    /**
     * The method that resets the current state of the generator
     * by entering a parameter can also be initialized.
     *
     * @dataProvider dataProviderTestInit
     * @param array $testCase
     */
    public function testInit(array $testCase)
    {
        $randomnessGenerator = $this->createGenerator($testCase);

        $randomnessGenerator->init();
        $this->assertEquals(0, $randomnessGenerator->getSeed());

        $randomnessGenerator->init(null, 20);
        $this->assertEquals(20, $randomnessGenerator->getCurrentState());
    }

    /**
     * Data provider for testInit.
     *
     * @return \Generator
     */
    public function dataProviderTestInit()
    {
        yield [
            [
                'seed' => 0,
                'min' => 0,
                'max' => 10,
                'format' => [
                    [-1, -1],
                    [-1, -1],
                ],
            ],
        ];
    }

    /**
     * Check that the generate method sets the values in the given
     * matrix format and within the given range.
     *
     * @dataProvider dataProviderTestGenerate
     * @param array $testCase
     */
    public function testGenerate(array $testCase)
    {
        $randomnessGenerator = $this->createGenerator($testCase);

        foreach ($randomnessGenerator->generate() as $indexX => $row) {

            foreach ($row as $indexY => $field) {

                $this->assertNotEquals(-1, $field);

                $this->assertThat(
                    $randomnessGenerator->getValue($indexX, $indexY),
                    $this->logicalAnd(
                        $this->greaterThan($testCase['min'] - 1),
                        $this->lessThan($testCase['max'] + 1)
                    )
                );
            }
        }
    }

    /**
     * Data provider for testGenerate.
     *
     * @return \Generator
     */
    public function dataProviderTestGenerate()
    {
        yield [
            [
                'seed' => 0,
                'min' => 0,
                'max' => 10,
                'format' => [
                    [-1, -1],
                    [-1, -1],
                ],
            ],
        ];
        yield [
            [
                'seed' => 0,
                'min' => 0,
                'max' => 4,
                'format' => [
                    [-1, 2],
                    [-1, -1],
                ],
            ],
        ];
    }

    /**
     * Helper method to create generator with params and return it to test.
     * @param array $testCase
     * @return RandomGenerator
     */
    private function createGenerator(array $testCase)
    {
        return new RandomGenerator(
            $testCase['min'],
            $testCase['max'],
            $testCase['format'],
            $testCase['seed']
        );
    }
}