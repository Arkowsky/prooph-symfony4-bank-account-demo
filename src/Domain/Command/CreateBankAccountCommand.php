<?php

declare(strict_types=1);

namespace App\Domain\Command;

use App\Domain\BankAccountNumber;
use Money\Currency;
use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;

class CreateBankAccountCommand extends Command implements PayloadConstructable
{
    use PayloadTrait;

    public function ownerName()
    {
        return $this->payload()['ownerName'];
    }

    public function bankAccountNumber(): BankAccountNumber
    {
        return $this->payload()['bankAccountNumber'];
    }

    public function currency(): Currency
    {
        return $this->payload()['currency'];
    }
}