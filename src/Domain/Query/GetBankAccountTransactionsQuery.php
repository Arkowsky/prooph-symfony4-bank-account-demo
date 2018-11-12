<?php

namespace App\Domain\Query;

use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;

class GetBankAccountTransactionsQuery extends Command implements PayloadConstructable
{
    use PayloadTrait;

    public function bankAccountNumber()
    {
        return $this->payload()['bankAccountNumber'];
    }
}