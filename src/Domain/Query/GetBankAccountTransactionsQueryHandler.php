<?php

namespace App\Domain\Query;

use App\Projection\Transaction\TransactionFinder;
use React\Promise\Deferred;

class GetBankAccountTransactionsQueryHandler
{
    /**
     * @var TransactionFinder
     */
    private $transactionFinder;

    public function __construct(TransactionFinder $transactionFinder)
    {
        $this->transactionFinder = $transactionFinder;
    }

    public function __invoke(GetBankAccountTransactionsQuery $command, Deferred $deferred = null)
    {
        $transactions = $this->transactionFinder->findAllForBankAccount($command->bankAccountNumber());
        if (null === $deferred) {
            return $transactions;
        }

        $deferred->resolve($transactions);
    }
}