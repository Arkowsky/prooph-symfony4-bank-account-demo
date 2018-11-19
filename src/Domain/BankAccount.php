<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\DomainEvent\BankAccountCreated;
use App\Domain\DomainEvent\DepositPerformed;
use App\Domain\DomainEvent\MoneyWithdrawn;
use Money\Currency;
use Money\Money;
use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\AggregateRoot;
use Ramsey\Uuid\Uuid;

class BankAccount extends AggregateRoot
{
    /**
     * @var BankAccountNumber
     */
    private $number;

    /**
     * @var string
     */
    private $ownerName;

    /**
     * @var Money
     */
    private $currentBalance = 0;

    /**
     * @var \DateTime
     */
    private $lastUpdate;

    static public function addNewWithData(BankAccountNumber $bankAccountNumber, string $ownerName, Currency $currency)
    {
        $bankAccount = new self();
        $bankAccount->recordThat(
            BankAccountCreated::occur(
                $bankAccountNumber->toString(),
                [
                    'ownerName' => $ownerName,
                    'currency' => $currency->getCode()
                ]
            )
        );

        return $bankAccount;
    }

    public function performDeposit(Uuid $transactionId, Money $amount)
    {
        $this->recordThat(
            DepositPerformed::occur(
                $this->aggregateId(),
                [
                    'amount' => $amount->absolute()->getAmount(),
                    'currency' => $amount->getCurrency(),
                    'transactionId' => $transactionId,
                    'balanceAfterTransaction' => $this->currentBalance + $amount->getAmount(),
                ]
            )
        );
    }

    public function withdrawMoney(Uuid $transactionId, Money $amount)
    {
        $this->recordThat(
            MoneyWithdrawn::occur(
                $this->aggregateId(),
                [
                    'amount' => $amount->absolute()->getAmount(),
                    'currency' => $amount->getCurrency(),
                    'transactionId' => $transactionId,
                    'balanceAfterTransaction' => $this->currentBalance + $amount->getAmount(),
                ]
            )
        );
    }

    protected function aggregateId(): string
    {
        return $this->number->toString();
    }

    /**
     * Apply given event
     */
    protected function apply(AggregateChanged $event): void
    {
        switch (get_class($event)) {
            case BankAccountCreated::class:
                $this->number = BankAccountNumber::fromString($event->aggregateId());
                $this->ownerName = $event->ownerName();
                $this->lastUpdate = new \DateTime($event->createdAt()->format(DATE_ATOM));
                break;
            case DepositPerformed::class:
                /** @var DepositPerformed $event */
                $this->currentBalance = $event->balanceAfterTransaction();
                break;
            case MoneyWithdrawn::class:
                /** @var MoneyWithdrawn $event */
                $this->currentBalance = $event->balanceAfterTransaction();
                break;
            default:
                throw new \RuntimeException('Invalid event given');
        }
    }

    public function number(): BankAccountNumber
    {
        return $this->number;
    }

    public function ownerName(): string
    {
        return $this->ownerName;
    }

    public function lastUpdate(): \DateTime
    {
        return $this->lastUpdate;
    }
}