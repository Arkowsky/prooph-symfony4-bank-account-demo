<?php

declare(strict_types=1);

namespace App\Domain\Query;

use App\Domain\BankAccountNumber;

class GetBankAccountQuery
{
    /**
     * @var BankAccountNumber
     */
    private $bankAccountNumber;

    public function __construct(BankAccountNumber $bankAccountNumber)
    {
        $this->bankAccountNumber = $bankAccountNumber;
    }

    public function bankAccountNumber(): BankAccountNumber
    {
        return $this->bankAccountNumber;
    }
}