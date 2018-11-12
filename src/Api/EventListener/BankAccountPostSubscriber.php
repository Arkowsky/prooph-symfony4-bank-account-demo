<?php

declare(strict_types=1);

namespace App\Api\EventListener;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Domain\BankAccountNumber;
use App\Domain\Command\CreateBankAccountCommand;
use App\Domain\Command\CreateBankAccountCommandHandler;
use App\DTO\BankAccount;
use Money\Currency;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class BankAccountPostSubscriber implements EventSubscriberInterface
{
    /** @var CreateBankAccountCommandHandler */
    private $createBankAccountCommandHandler;

    public function __construct(CreateBankAccountCommandHandler $createBankAccountCommandHandler)
    {
        $this->createBankAccountCommandHandler = $createBankAccountCommandHandler;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => [
                'write',
                EventPriorities::PRE_WRITE,
            ]
        ];
    }

    public function write(GetResponseForControllerResultEvent $event)
    {
        /** @var BankAccount $dtoBankAccount */
        $dtoBankAccount = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$dtoBankAccount instanceof BankAccount || Request::METHOD_POST !== $method) {
            return;
        }

        $bankAccountNumber = BankAccountNumber::generateNew();

        $this->createBankAccountCommandHandler->handle(
            new CreateBankAccountCommand(
                [
                    'bankAccountNumber' => $bankAccountNumber,
                    'ownerName' => $dtoBankAccount->getOwnerName(),
                    'currency' => new Currency($dtoBankAccount->getCurrency())
                ]
            )
        );

        $dtoBankAccount->setNumber($bankAccountNumber->toString());
    }
}