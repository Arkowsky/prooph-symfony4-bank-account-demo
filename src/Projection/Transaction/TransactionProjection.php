<?php

declare(strict_types=1);

namespace App\Projection\Transaction;

use App\Domain\BankAccountNumber;
use App\Domain\DomainEvent\DepositPerformed;
use App\Domain\DomainEvent\MoneyWithdrawn;
use Prooph\Bundle\EventStore\Projection\ReadModelProjection;
use Prooph\EventStore\Projection\ReadModelProjector;

class TransactionProjection implements ReadModelProjection
{
    public function project(ReadModelProjector $projector): ReadModelProjector
    {
        $projector
            ->fromAll()
            ->when([
                MoneyWithdrawn::class => function ($state, MoneyWithdrawn $event) {
                    /** @var TransactionReadModel $readModel */
                    $readModel = $this->readModel();

                    $bankAccountNumber = BankAccountNumber::fromString($event->aggregateId());

                    $readModel->stack('insert', [
                        'transaction_id' => $event->transactionId(),
                        'bank_account_number' => $bankAccountNumber->toString(),
                        'amount' => $event->amount() * (-1),
                        'currency' => $event->currency(),
                        'balance_after_transaction' => $event->balanceAfterTransaction(),
                        'created_at' => $event->createdAt()->format("Y-m-d H:i:s"),
                    ]);
                },
                DepositPerformed::class => function ($state, DepositPerformed $event) {
                    /** @var TransactionReadModel $readModel */
                    $readModel = $this->readModel();

                    $bankAccountNumber = BankAccountNumber::fromString($event->aggregateId());

                    $readModel->stack('insert', [
                        'transaction_id' => $event->transactionId(),
                        'bank_account_number' => $bankAccountNumber->toString(),
                        'amount' => $event->amount(),
                        'currency' => $event->currency(),
                        'balance_after_transaction' => $event->balanceAfterTransaction(),
                        'created_at' => $event->createdAt()->format("Y-m-d H:i:s"),
                    ]);
                }
            ]);

        return $projector;
    }
}