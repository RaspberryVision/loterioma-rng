<?php

namespace App\Tests\Generator;

use PHPUnit\Framework\TestCase;

class RandomnessGeneratorTest extends TestCase
{
    public function testCreateInstance()
    {
        $randomnessGenerator = new RandomnessGenerator(213, [0, 5], [
            [0, 0, 0],
            [0, 0, 0],
            [0, 0, 0]
        ]);

        $this->assertEquals(213, $randomnessGenerator->getSeed());

        $this->assertEquals(0, $randomnessGenerator->getMin());

        $this->assertEquals(5, $randomnessGenerator->getMax());

        $this->assertEquals([
            [0, 0, 0],
            [0, 0, 0],
            [0, 0, 0]
        ], $randomnessGenerator->getMatrix());
    }

    public function testDoesImplementRandomGenerableInterface()
    {
        $randomnessGenerator = new RandomnessGenerator(213, [0, 5], [
            [0, 0, 0],
            [0, 0, 0],
            [0, 0, 0]
        ]);

        $this->assertInstanceOf(RandomGenerableInterface::class, $randomnessGenerator);
    }

    public function testSetCurrentState()
    {

        $matrix = [
            [-1, -1, -1],
            [-1, -1, -1],
            [-1, -1, -1]
        ];

        $randomnessGenerator = new RandomnessGenerator(213, [0, 5], $matrix);

        $randomnessGenerator->setCurrentState(23);

        $this->assertEquals(23, $randomnessGenerator->getCurrentState());
    }

    public function testReset()
    {
        $matrix = [
            [-1, -1, -1],
            [-1, -1, -1],
            [-1, -1, -1]
        ];

        $randomnessGenerator = new RandomnessGenerator(213, [0, 5], $matrix);

        $randomnessGenerator->setCurrentState(23);

        $randomnessGenerator->resetState();

        $this->assertEquals(0, $randomnessGenerator->getCurrentState());

        $randomnessGenerator->resetState(20);

        $this->assertEquals(20, $randomnessGenerator->getCurrentState());
    }

    public function testGenerate()
    {
        $matrix = [
            [-1, -1, -1],
            [-1, -1, -1],
            [-1, -1, -1]
        ];

        $randomnessGenerator = new RandomnessGenerator(213, [0, 5], $matrix);

        foreach ($matrix as $row => $indexX) {

            foreach ($row as $field => $indexY) {

                $this->assertNotEquals(-1, $randomnessGenerator->getValue($indexX, $indexY));

                $this->assertThat(
                    $randomnessGenerator->getValue($indexX, $indexY),
                    $this->logicalAnd(
                        $this->greaterThan(0),
                        $this->lessThan(5)
                    )
                );
            }
        }
    }
}