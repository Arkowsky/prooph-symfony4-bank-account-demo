<?php

namespace App\Domain\Query;

use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;

class GetTransactionQuery extends Command implements PayloadConstructable
{
    use PayloadTrait;

    public function transactionId()
    {
        return $this->payload()['transactionId'];
    }
}