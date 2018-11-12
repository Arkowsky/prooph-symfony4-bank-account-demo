<?php

namespace App\Domain\Command;

use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;

class WithdrawMoneyCommand extends Command implements PayloadConstructable
{
    use PayloadTrait;

    public function amount()
    {
        return $this->payload()['amount'];
    }

    public function bankAccountNumber()
    {
        return $this->payload()['accountNumber'];
    }

    public function transactionId()
    {
        return $this->payload()['transactionId'];
    }
}