<?php

declare(strict_types=1);

namespace App\Domain\DomainEvent;

use Prooph\EventSourcing\AggregateChanged;

class BankAccountCreated extends AggregateChanged
{
    public function ownerName(): string
    {
        return $this->payload['ownerName'];
    }

    public function currency()
    {
        return $this->payload()['currency'];
    }
}