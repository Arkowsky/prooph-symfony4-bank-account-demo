<?php

declare(strict_types=1);

namespace App\Domain\Query;

use App\Domain\BankAccountNumber;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;
use Prooph\Common\Messaging\Query;

class GetBankAccountQuery extends Query implements PayloadConstructable
{
    use PayloadTrait;

    public function bankAccountNumber(): BankAccountNumber
    {
        return $this->payload()['bankAccountNumber'];
    }
}