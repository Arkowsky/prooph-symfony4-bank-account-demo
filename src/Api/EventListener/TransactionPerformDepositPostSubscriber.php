<?php

namespace App\Api\EventListener;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Domain\BankAccountNumber;
use App\Domain\Command\PerformDepositCommand;
use App\Domain\Command\PerformDepositCommandHandler;
use App\DTO\Transaction;
use Ramsey\Uuid\Uuid;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class TransactionPerformDepositPostSubscriber implements EventSubscriberInterface
{
    /**
     * @var PerformDepositCommandHandler
     */
    private $commandHandler;

    public function __construct(PerformDepositCommandHandler $commandHandler)
    {
        $this->commandHandler = $commandHandler;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => [
                'write',
                EventPriorities::PRE_WRITE
            ]
        ];
    }

    public function write(GetResponseForControllerResultEvent $event)
    {
        /** @var Transaction $dtoTransaction */
        $dtoTransaction = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$dtoTransaction instanceof Transaction
            || Request::METHOD_POST !== $method
            || $dtoTransaction->getAmount() <= 0
        ) {
            return;
        }

        $transactionId = Uuid::uuid4();
        $bankAccountNumber = BankAccountNumber::fromString($dtoTransaction->getBankAccountNumber());

        $this->commandHandler->handle(
            new PerformDepositCommand(
                [
                    'accountNumber' => $bankAccountNumber,
                    'transactionId' => $transactionId,
                    'amount' => $dtoTransaction->getAmount(),
                    'currency' => $dtoTransaction->getCurrency()
                ]
            )
        );

        $dtoTransaction->setTransactionId($transactionId);
    }
}