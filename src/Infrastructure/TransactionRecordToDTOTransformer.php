<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\DTO\Transaction;
use App\Projection\Transaction\TransactionRecordTransformerInterface;
use Ramsey\Uuid\Uuid;

class TransactionRecordToDTOTransformer implements TransactionRecordTransformerInterface
{
    public function toDTO(array $transactionRecord)
    {
        return (new Transaction())
            ->setTransactionId(Uuid::fromString($transactionRecord['transaction_id']))
            ->setAmount(floatval($transactionRecord['amount']))
            ->setBankAccountNumber($transactionRecord['bank_account_number'])
            ->setBalanceAfterTransaction(floatval($transactionRecord['balance_after_transaction']))
            ->setCurrency($transactionRecord['currency']);
    }
}