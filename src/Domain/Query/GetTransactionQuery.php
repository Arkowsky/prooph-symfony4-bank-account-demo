<?php

namespace App\Domain\Query;

use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;
use Prooph\Common\Messaging\Query;

class GetTransactionQuery extends Query implements PayloadConstructable
{
    use PayloadTrait;

    public function transactionId()
    {
        return $this->payload()['transactionId'];
    }
}