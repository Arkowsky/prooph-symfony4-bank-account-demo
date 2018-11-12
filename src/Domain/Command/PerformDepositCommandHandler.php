<?php

namespace App\Domain\Command;

use App\Domain\BaseBankAccountRepository;
use App\Domain\Exception\BankAccountNotFoundException;
use Money\Money;

class PerformDepositCommandHandler
{
    /**
     * @var BaseBankAccountRepository
     */
    private $bankAccountRepository;

    function __construct(BaseBankAccountRepository $bankAccountRepository)
    {
        $this->bankAccountRepository = $bankAccountRepository;
    }

    public function handle(PerformDepositCommand $command)
    {
        $bankAccount = $this->bankAccountRepository->get($command->bankAccountNumber());

        $money = Money::EUR($command->amount());

        if (!$bankAccount) {
            throw BankAccountNotFoundException::fromAccountNumber($command->bankAccountNumber());
        }

        $bankAccount->performDeposit($command->transactionId(), $money);

        $this->bankAccountRepository->save($bankAccount);
    }
}