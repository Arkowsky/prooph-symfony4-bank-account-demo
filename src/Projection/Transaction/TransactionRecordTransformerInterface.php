<?php

namespace App\Projection\Transaction;

interface TransactionRecordTransformerInterface
{
    public function toDTO(array $transactionRecord);
}