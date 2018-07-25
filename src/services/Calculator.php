<?php

namespace app\services;

use app\impl\operations\Addition;
use app\impl\operations\Subtraction;
use app\infrastructure\Term;

/**
 * Class Calculator
 *
 * @author Ilya Kolesnikov <igkolesn@mts.ru>
 * @package app\services
 */
class Calculator
{
    /**
     * @param Term $term1
     * @param Term $term2
     * @return Term
     */
    public function addition(Term $term1, Term $term2)
    {
        $operation = new Addition();

        switch (true) {
            case $term1->isMinus() && !$term2->isMinus():
                $this->swap($term1, $term2);
                $term2->setMinus(false);
                $operation = new Subtraction();

                break;

            case !$term1->isMinus() && $term2->isMinus():
                $term2->setMinus(false);
                $operation = new Subtraction();

                break;

            case $term1->isMinus() && $term2->isMinus():
                $this->swap($term1, $term2);
                $term1->setMinus(false);
                $term2->setMinus(false);
                $operation = new Subtraction();

                break;
        }

        return $operation->exec($term1, $term2);
    }

    /**
     * @param Term $term1
     * @param Term $term2
     * @return Term
     */
    public function subtraction(Term $term1, Term $term2)
    {
        $operation = new Subtraction();
        $isMinus = false;

        switch (true) {
            case $term1->isMinus() && !$term2->isMinus():
                $term1->setMinus(false);
                $term2->setMinus(false);
                $operation = new Addition();
                $isMinus = true;

                break;

            case !$term1->isMinus() && $term2->isMinus():
                $term2->setMinus(false);
                $operation = new Addition();

                break;

            case $term1->isMinus() && $term2->isMinus():
                $this->swap($term1, $term2);
                $term1->setMinus(false);
                $term2->setMinus(false);
                $operation = new Subtraction();

                break;
        }

        $result = $operation->exec($term1, $term2);

        if ($isMinus) {
            $result->setMinus($isMinus);
        }

        return $result;
    }

    /**
     * @param Term $term1
     * @param Term $term2
     */
    protected function swap(Term $term1, Term $term2)
    {
        $tmp = Term::fromArray($term1->toArray());

        $term1->setDigits($term2->getDigits());
        $term1->setMinus($term2->isMinus());

        $term2->setDigits($tmp->getDigits());
        $term2->setMinus($tmp->isMinus());
    }
}