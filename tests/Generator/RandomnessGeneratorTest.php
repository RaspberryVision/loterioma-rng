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

use PHPUnit\Framework\TestCase;
use App\Generator\RandomnessGenerableInterface;
use App\Generator\RandomnessGenerator;

class RandomnessGeneratorTest extends TestCase
{
    /**
     * Check that RandomnessGenerator class implement RandomGenerableInterface.
     *
     * @dataProvider dataProviderCreateInstance
     * @param array $testCase
     */
    public function testDoesImplementRandomGenerableInterface(array $testCase)
    {
        $randomnessGenerator = $this->createGenerator($testCase);

        $this->assertInstanceOf(RandomnessGenerableInterface::class, $randomnessGenerator);
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
        $this->assertEquals($testCase['range']['min'], $randomnessGenerator->getMin());
        $this->assertEquals($testCase['range']['max'], $randomnessGenerator->getMax());
        $this->assertEquals($testCase['matrix'], $randomnessGenerator->getMatrix());
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
                'range' => [
                    'min' => 0,
                    'max' => 10
                ],
                'matrix' => [
                    [-1, -1],
                    [-1, -1]
                ]
            ]
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
                'range' => [
                    'min' => 0,
                    'max' => 10
                ],
                'matrix' => [
                    [-1, -1],
                    [-1, -1]
                ]
            ]
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

        $randomnessGenerator->generate();

        foreach ($randomnessGenerator->getMatrix() as $indexX => $row) {

            foreach ($row as $indexY => $field) {

                $this->assertNotEquals(-1, $randomnessGenerator->getValue(
                    $indexX, $indexY
                ));

                $this->assertThat(
                    $randomnessGenerator->getValue($indexX, $indexY),
                    $this->logicalAnd(
                        $this->greaterThan($testCase['range']['min'] - 1),
                        $this->lessThan($testCase['range']['max'] + 1)
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
                'range' => [
                    'min' => 0,
                    'max' => 10
                ],
                'matrix' => [
                    [-1, -1],
                    [-1, -1]
                ]
            ]
        ];
    }

    /**
     * Helper method to create generator with params and return it to test.
     * @param array $testCase
     * @return RandomnessGenerator
     */
    private function createGenerator(array $testCase)
    {
        return new RandomnessGenerator(
            $testCase['seed'],
            [
                $testCase['range']['min'],
                $testCase['range']['max']
            ],
            $testCase['matrix']
        );
    }
}