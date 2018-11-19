<?php

namespace App\Domain\Query;

use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;
use Prooph\Common\Messaging\Query;

class GetBankAccountTransactionsQuery extends Query implements PayloadConstructable
{
    use PayloadTrait;

    public function bankAccountNumber()
    {
        return $this->payload()['bankAccountNumber'];
    }
}