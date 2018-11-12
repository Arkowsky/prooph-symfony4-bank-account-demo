<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\DTO\BankAccount;
use App\Projection\BankAccount\BankAccountRecordTransformerInterface;

class BankAccountRecordToDTOTransformer implements BankAccountRecordTransformerInterface
{
    public function toDTO(array $bankAccountRecord)
    {
        return (new BankAccount($bankAccountRecord['owner_name']))
            ->setLastUpdate(new \DateTime())
            ->setNumber($bankAccountRecord['number'])
            ->setCurrentBalance(floatval($bankAccountRecord['current_balance']))
            ->setCurrency($bankAccountRecord['currency'])
            ->setOwnerName($bankAccountRecord['owner_name']);
    }
}