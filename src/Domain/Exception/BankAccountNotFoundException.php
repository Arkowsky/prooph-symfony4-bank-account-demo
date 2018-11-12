<?php

namespace App\Domain\Exception;

use App\Domain\BankAccountNumber;

class BankAccountNotFoundException extends \Exception
{
    static public function fromAccountNumber(BankAccountNumber $bankAccountNumber)
    {
        return new self(sprintf('Bank account %s not found ', $bankAccountNumber->toString()));
    }
}