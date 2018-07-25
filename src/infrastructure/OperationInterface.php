<?php

namespace app\infrastructure;

/**
 * Interface OperationInterface
 *
 * @author Ilya Kolesnikov <fatumm@gmail.com>
 * @package app\infrastructure
 */
interface OperationInterface
{
    /**
     * @param Term $term1
     * @param Term $term2
     * @return Term
     */
    public function exec(Term $term1, Term $term2);
}