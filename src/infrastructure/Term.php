<?php

namespace app\infrastructure;

/**
 * Class Term
 *
 * @author Ilya Kolesnikov <igkolesn@mts.ru>
 * @package app\infrastructure
 */
class Term
{
    /**
     * @var array
     */
    private $digits = [];

    /**
     * @var bool
     */
    private $isMinus = false;

    /**
     * Term constructor.
     *
     * @param array $digits
     */
    public function __construct(array $digits)
    {
        $first = reset($digits);

        if ($first === '+' || $first === '-') {
            array_shift($digits);
            $this->isMinus = $first === '-' && (count($digits) > 1 || reset($digits) != 0);
        }

        $this->digits = array_values($digits);

    }

    /**
     * @param array $digits
     * @return Term
     */
    public static function fromArray(array $digits)
    {
        $first = null;

        if ($digits) {
            $first = reset($digits);

            if ($first === '+' || $first === '-') {
                array_shift($digits);
            } else {
                $first = null;
            }

            $lock = count($digits) > 1;

            for ($i = 0, $count = count($digits); $i < $count; $i++) {
                if ($digits[$i]) {
                    $lock = false;
                }

                if ($lock) {
                    unset($digits[$i]);
                }
            }
        }

        return new static(array_values(array_merge($first ? [$first] : [], $digits)));
    }

    /**
     * @param string $data
     * @return Term
     */
    public static function fromString($data)
    {
        return static::fromArray(str_split($data));
    }

    /**
     * @param Term $term
     * @return bool
     */
    public function isGreaterThan(Term $term)
    {
        if ($this->isMinus() && !$term->isMinus()) {
            return false;
        }

        if (!$this->isMinus() && $term->isMinus()) {
            return true;
        }

        $digits1 = $this->getDigits();
        $digits2 = $term->getDigits();

        if (count($digits1) > count($digits2)) {
            return true;
        } elseif (count($digits2) > count($digits1)) {
            return false;
        }

        for ($i = 0, $count = count($digits1); $i < $count; $i++) {
            if ((int)$digits1[$i] > (int)$digits2[$i]) {
                return true;
            } else {
                break;
            }
        }

        return false;
    }

    /**
     * @param bool $isMinus
     * @return Term
     */
    public function setMinus($isMinus = true)
    {
        $this->isMinus = $isMinus;
        return $this;
    }

    /**
     * @return array
     */
    public function getDigits()
    {
        return $this->digits;
    }

    /**
     * @param array $digits
     */
    public function setDigits(array $digits)
    {
        $this->digits = $digits;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array_merge($this->isMinus() ? ['-'] : [], $this->digits);
    }

    /**
     * @return string
     */
    public function toString()
    {
        return implode('', $this->toArray());
    }

    /**
     * @return bool
     */
    public function isMinus()
    {
        return $this->isMinus;
    }
}