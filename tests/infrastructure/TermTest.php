<?php

namespace tests\infrastructure;

use app\infrastructure\Term;
use PHPUnit\Framework\TestCase;

/**
 * Class TermTest
 *
 * @author Ilya Kolesnikov <igkolesn@mts.ru>
 * @package tests\infrastructure
 */
class TermTest extends TestCase
{
    /**
     * @covers Term::fromArray()
     */
    public function testFromArray()
    {
        // arrange
        $term = Term::fromArray(['-', 0, 0, 1, 0, 0, 0, 1]);

        // act

        // assert
        $this->assertTrue($term->isMinus());
        $this->assertEquals('-10001', $term->toString());
        $this->assertEquals(['-', 1, 0, 0, 0, 1], $term->toArray());
        $this->assertEquals([1, 0, 0, 0, 1], $term->getDigits());
    }

    /**
     * @covers Term::fromString()
     */
    public function testFromString()
    {
        // arrange
        $term = Term::fromString('-10001');

        // act

        // assert
        $this->assertTrue($term->isMinus());
        $this->assertEquals('-10001', $term->toString());
        $this->assertEquals(['-', 1, 0, 0, 0, 1], $term->toArray());
        $this->assertEquals([1, 0, 0, 0, 1], $term->getDigits());
    }

    public function providerIsGreaterThan()
    {
        return [
            [1, 0, true],
            [39, 81, false],
            [10, 11, false],
            [99, 100, false],
            [99, -100, true],
            [-99, -100, false],
        ];
    }

    /**
     * @param string $term1
     * @param string $term2
     * @param bool $result
     *
     * @dataProvider providerIsGreaterThan
     * @covers Term::isGreaterThan()
     */
    public function testIsGreaterThan($term1, $term2, $result)
    {
        // arrange
        $term1 = Term::fromString($term1);
        $term2 = Term::fromString($term2);

        // act

        // assert
        $this->assertSame($result, $term1->isGreaterThan($term2));
    }
}