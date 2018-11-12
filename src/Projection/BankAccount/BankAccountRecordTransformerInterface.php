<?php

declare(strict_types=1);

namespace App\Projection\BankAccount;

interface BankAccountRecordTransformerInterface
{
    public function toDTO(array $bankAccountRecord);
}