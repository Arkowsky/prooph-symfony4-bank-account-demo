<?php

namespace App\Domain\DomainEvent;

use Prooph\EventSourcing\AggregateChanged;

class DepositPerformed extends AggregateChanged
{
    public function transactionId(): string
    {
        return $this->payload['transactionId'];
    }

    public function amount()
    {
        return $this->payload()['amount'];
    }

    public function currency()
    {
        return $this->payload()['currency'];
    }

    public function balanceAfterTransaction()
    {
        return $this->payload()['balanceAfterTransaction'];
    }
}