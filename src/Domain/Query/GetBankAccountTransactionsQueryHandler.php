<?php

namespace App\Domain\Query;

use App\Projection\Transaction\TransactionFinder;

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

    public function handle(GetBankAccountTransactionsQuery $command)
    {
        return $this->transactionFinder->findAllForBankAccount($command->bankAccountNumber());
    }
}