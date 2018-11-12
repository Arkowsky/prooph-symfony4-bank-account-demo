<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\BankAccount;
use App\Domain\BankAccountNumber;
use App\Domain\BaseBankAccountRepository;
use Prooph\EventSourcing\Aggregate\AggregateRepository;
use Prooph\EventSourcing\Aggregate\AggregateType;
use Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator;
use Prooph\EventStore\EventStore;

final class BankAccountRepository extends AggregateRepository implements BaseBankAccountRepository
{
    public function __construct(EventStore $eventStore)
    {
        parent::__construct(
            $eventStore,
            AggregateType::fromAggregateRootClass(BankAccount::class),
            new AggregateTranslator(),
            null,
            null,
            true
            );
    }

    public function save(BankAccount $bankAccount): void
    {
        $this->saveAggregateRoot($bankAccount);
    }

    public function get(BankAccountNumber $bankAccountNumber): ?BankAccount
    {
        return $this->getAggregateRoot($bankAccountNumber->toString());
    }
} 