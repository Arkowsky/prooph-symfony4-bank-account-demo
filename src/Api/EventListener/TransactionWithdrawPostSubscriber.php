<?php

namespace App\Api\EventListener;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Domain\BankAccountNumber;
use App\Domain\Command\WithdrawMoneyCommand;
use App\Domain\Command\WithdrawMoneyCommandHandler;
use App\DTO\Transaction;
use Ramsey\Uuid\Uuid;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class TransactionWithdrawPostSubscriber implements EventSubscriberInterface
{
    /**
     * @var WithdrawMoneyCommandHandler
     */
    private $commandHandler;

    public function __construct(WithdrawMoneyCommandHandler $commandHandler)
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
            || $dtoTransaction->getAmount() >= 0
        ) {
            return;
        }

        $transactionId = Uuid::uuid4();
        $bankAccountNumber = BankAccountNumber::fromString($dtoTransaction->getBankAccountNumber());

        $this->commandHandler->handle(
            new WithdrawMoneyCommand(
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