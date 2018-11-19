<?php

declare(strict_types=1);

namespace App\Projection\BankAccount;

use App\Domain\BankAccountNumber;
use App\Domain\DomainEvent\BankAccountCreated;
use App\Domain\DomainEvent\DepositPerformed;
use App\Domain\DomainEvent\MoneyWithdrawn;
use Prooph\Bundle\EventStore\Projection\ReadModelProjection;
use Prooph\EventStore\Projection\ReadModelProjector;

class BankAccountProjection implements ReadModelProjection
{
    public function project(ReadModelProjector $projector): ReadModelProjector
    {
        $projector
            ->fromCategory('App\Domain\BankAccount')
            ->when([
                BankAccountCreated::class => function ($state, BankAccountCreated $event) {
                    /** @var BankAccountReadModel $readModel */
                    $readModel = $this->readModel();

                    $readModel->stack('insert', [
                        'number' => $event->aggregateId(),
                        'owner_name' => $event->ownerName(),
                        'current_balance' => 0,
                        'currency' => $event->currency(),
                        'last_update' => $event->createdAt()->format("Y-m-d H:i:s"),
                    ]);
                },
                MoneyWithdrawn::class => function ($state, MoneyWithdrawn $event) {
                    /** @var BankAccountReadModel $readModel */
                    $readModel = $this->readModel();

                    $bankAccountNumber = BankAccountNumber::fromString($event->aggregateId());

                    $readModel->stack('update',
                        [
                            'current_balance' => $event->balanceAfterTransaction(),
                        ],
                        [
                            'number' => $bankAccountNumber->toString(),
                        ]
                    );
                },
                DepositPerformed::class => function ($state, DepositPerformed $event) {
                    /** @var BankAccountReadModel $readModel */
                    $readModel = $this->readModel();

                    $bankAccountNumber = BankAccountNumber::fromString($event->aggregateId());

                    $readModel->stack('update',
                        [
                            'current_balance' => $event->balanceAfterTransaction(),
                        ],
                        [
                            'number' => $bankAccountNumber->toString(),
                        ]
                    );
                }
            ]);

        return $projector;
    }
}