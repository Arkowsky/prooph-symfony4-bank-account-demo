<?php

declare(strict_types=1);

namespace App\Domain\Query;

use App\Projection\BankAccount\BankAccountFinder;

class GetBankAccountQueryHandler
{
    /** @var BankAccountFinder */
    private $bankAccountFinder;

    public function __construct(BankAccountFinder $bankAccountFinder)
    {
        $this->bankAccountFinder = $bankAccountFinder;
    }

    public function handle(GetBankAccountQuery $bankAccountCommand)
    {
        $bankAccount = $this->bankAccountFinder->findByAccountNumber(
            $bankAccountCommand->bankAccountNumber()->toString()
        );

        return $bankAccount;
    }
}