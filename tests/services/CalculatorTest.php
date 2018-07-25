<?php

namespace tests\services;

use app\infrastructure\Term;
use app\services\Calculator;
use PHPUnit\Framework\TestCase;

/**
 * Class CalculatorTest
 *
 * @author Ilya Kolesnikov <igkolesn@mts.ru>
 * @package tests\services
 */
class CalculatorTest extends TestCase
{
    public function providerAddition()
    {
        return [
            [1, 2, 3],
            [1, 9, 10],
            [1, 99, 100],
            [1, 199, 200],
            [20, 1000, 1020],
            [999, 11, 1010],
            [0, 1, 1],
            [
                '100000000000000000000000000000000000000000000000000000000000011',
                '900000000000000000000000000000000000000000000000000000000000001',
                '1000000000000000000000000000000000000000000000000000000000000012'
            ],
            [
                '-1', 10, 9,
            ],
            [
                10, '-1', 9
            ],
            [
                '-1', '-9', 8
            ],
            [
                '-10', 1, '-9'
            ]
        ];
    }

    /**
     * @param string $term1
     * @param string $term2
     * @param string $term3
     *
     * @dataProvider providerAddition
     * @covers Calculator::addition()
     */
    public function testAddition($term1, $term2, $term3)
    {
        // arrange
        $object = $this->getObject();
        $term1 = $this->getTerm($term1);
        $term2 = $this->getTerm($term2);

        // act
        $result = $object->addition($term1, $term2);

        // assert
        $this->assertEquals($result->toString(), $term3);
    }

    public function providerSubtraction()
    {
        return [
            [1, 1, 0],
            [100, 10, 90],
            [1, 100, '-99'],
            [1, 9, '-8'],
            [39, 81, '-42'],
            [1, 90, '-89'],
            ['-1', 9, '-10'],
            [1, '-9', 10],
            ['-1', '-9', 8],
        ];
    }

    /**
     * @param string $term1
     * @param string $term2
     * @param string $term3
     *
     * @dataProvider providerSubtraction
     * @covers Calculator::subtraction()
     */
    public function testSubtraction($term1, $term2, $term3)
    {
        // arrange
        $object = $this->getObject();
        $term1 = $this->getTerm($term1);
        $term2 = $this->getTerm($term2);

        // act
        $result = $object->subtraction($term1, $term2);

        // assert
        $this->assertEquals($result->toString(), $term3);
    }

    /**
     * @return Calculator
     */
    private function getObject()
    {
        return new Calculator();
    }

    /**
     * @param string $term
     * @return Term
     */
    private function getTerm($term)
    {
        return Term::fromString($term);
    }
}