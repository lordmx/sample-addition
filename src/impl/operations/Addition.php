<?php

namespace app\impl\operations;

use app\infrastructure\OperationInterface;
use app\infrastructure\Term;

/**
 * Class Addition
 *
 * @author Ilya Kolesnikov <igkolesn@mts.ru>
 * @package app\impl\operations
 */
class Addition implements OperationInterface
{
    /**
     * @inheritDoc
     */
    public function exec(Term $term1, Term $term2)
    {
        $digits1 = $term1->toArray();
        $digits2 = $term2->toArray();

        $max = max(count($digits1), count($digits2));

        $digits1 = array_reverse(array_pad($digits1, -$max, 0));
        $digits2 = array_reverse(array_pad($digits2, -$max, 0));
        $result = [];
        $prev = 0;

        for ($i = 0; $i < $max; $i++) {
            $sum = $digits1[$i] + $digits2[$i] + $prev;
            $digit = $sum % 10;
            $prev = (int)($sum > 9);

            $result[] = $digit;
        }

        $result = array_reverse($result);

        if ($prev > 0) {
            array_unshift($result, $prev);
        }

        return Term::fromArray($result);
    }

}