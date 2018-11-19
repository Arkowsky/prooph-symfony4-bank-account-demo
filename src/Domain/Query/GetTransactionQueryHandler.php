<?php

namespace App\Domain\Query;

use App\Projection\Transaction\TransactionFinder;
use React\Promise\Deferred;

class GetTransactionQueryHandler
{
    /**
     * @var TransactionFinder
     */
    private $transactionFinder;

    public function __construct(TransactionFinder $transactionFinder)
    {
        $this->transactionFinder = $transactionFinder;
    }

    public function __invoke(GetTransactionQuery $command, Deferred $deferred = null)
    {
        $transaction = $this->transactionFinder->findByTransactionId($command->transactionId());
        if (null === $deferred) {
            return $transaction;
        }

        $deferred->resolve($transaction);
    }
}