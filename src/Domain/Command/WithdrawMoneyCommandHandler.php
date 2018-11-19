<?php

namespace App\Domain\Command;

use App\Domain\BaseBankAccountRepository;
use App\Domain\Exception\BankAccountNotFoundException;
use Money\Money;

class WithdrawMoneyCommandHandler
{
    /**
     * @var BaseBankAccountRepository
     */
    private $bankAccountRepository;

    function __construct(BaseBankAccountRepository $bankAccountRepository)
    {
        $this->bankAccountRepository = $bankAccountRepository;
    }

    public function __invoke(WithdrawMoneyCommand $command)
    {
        $bankAccount = $this->bankAccountRepository->get($command->bankAccountNumber());

        $money = Money::EUR($command->amount());

        if (!$bankAccount) {
            throw BankAccountNotFoundException::fromAccountNumber($command->bankAccountNumber());
        }

        $bankAccount->withdrawMoney($command->transactionId(), $money);

        $this->bankAccountRepository->save($bankAccount);
    }
}