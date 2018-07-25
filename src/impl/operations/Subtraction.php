<?php

namespace app\impl\operations;

use app\infrastructure\OperationInterface;
use app\infrastructure\Term;

/**
 * Class Subtraction
 *
 * @author Ilya Kolesnikov <igkolesn@mts.ru>
 * @package app\impl\operations
 */
class Subtraction implements OperationInterface
{
    /**
     * @inheritDoc
     */
    public function exec(Term $term1, Term $term2)
    {
        $isMinus = false;

        if ($term2->isGreaterThan($term1)) {
            $tmp = $term1;
            $term1 = $term2;
            $term2 = $tmp;
            $isMinus = true;
        }

        $digits1 = $term1->toArray();
        $digits2 = $term2->toArray();

        $max = max(count($digits1), count($digits2));

        $digits1 = array_reverse(array_pad($digits1, -$max, 0));
        $digits2 = array_reverse(array_pad($digits2, -$max, 0));
        $result = [];
        $prev = 0;

        for ($i = 0; $i < $max; $i++) {
            $sub = $digits1[$i] - $digits2[$i] - $prev;

            if ($sub < 0) {
                $sub = 10 - abs($sub);
                $prev = 1;
            }

            $result[] = $sub;
        }

        $result = array_reverse($result);

        if ($prev > 0 && reset($result) == 0) {
            array_shift($result);
        }

        return Term::fromArray($result)->setMinus($isMinus);
    }

}