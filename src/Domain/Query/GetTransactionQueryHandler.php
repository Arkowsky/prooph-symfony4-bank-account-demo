<?php

namespace App\Domain\Query;

use App\Projection\Transaction\TransactionFinder;

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

    public function handle(GetTransactionQuery $command)
    {
        return $this->transactionFinder->findByTransactionId($command->transactionId());
    }
}