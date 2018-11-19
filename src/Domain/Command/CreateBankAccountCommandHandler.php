<?php

declare(strict_types=1);

namespace App\Domain\Command;

use App\Domain\BankAccount;
use App\Domain\BaseBankAccountRepository;

class CreateBankAccountCommandHandler
{
    /** @var BaseBankAccountRepository */
    private $bankAccountRepository;

    public function __construct(
        BaseBankAccountRepository $bankAccountRepository
    )
    {
        $this->bankAccountRepository = $bankAccountRepository;
    }

    public function __invoke(CreateBankAccountCommand $createBankAccountCommand): void
    {
        $bankAccount = BankAccount::addNewWithData(
            $createBankAccountCommand->bankAccountNumber(),
            $createBankAccountCommand->ownerName(),
            $createBankAccountCommand->currency()
        );

        $this->bankAccountRepository->save($bankAccount);
    }
}