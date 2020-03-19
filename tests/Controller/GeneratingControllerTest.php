<?php
/**
 * Web testing for GeneratingController class.
 *
 * ~
 *
 * @category   WebTests
 * @package    App\Tests\Controller
 * @author     Rafal Malik <kontakt@raspberryvision.pl>
 * @copyright  03.2020 Raspberry Vision
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GeneratingControllerTest extends WebTestCase
{
    /**
     * Web test for generate method.
     *
     * @dataProvider dataProviderTestGenerate
     * @param array $testCase
     */
    public function testGenerate(array $testCase)
    {
        $client = static::createClient();

        $client->request('GET', '/generate', $testCase['request']);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        /** @var array $resultedMatrix */
        $resultedMatrix = $client->getResponse()->getContent();

        foreach ($resultedMatrix as $indexY => $row) {

            foreach ($row as $indexX => $field) {
                $this->assertNotEquals(-1, $field);

                $this->assertThat(
                    $field,
                    $this->logicalAnd(
                        $this->greaterThan($testCase['request']['range']['min'] - 1),
                        $this->lessThan($testCase['request']['range']['max'] + 1)
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
                'request' => [
                    'seed' => 0,
                    'range' => [
                        'min' => 1,
                        'max' => 10
                    ],
                    'matrix' => [
                        [-1, -1],
                        [-1, -1]
                    ]
                ]
            ]
        ];
    }
}
