<?php

declare(strict_types=1);

namespace App\Domain\Query;

use App\Projection\BankAccount\BankAccountFinder;
use React\Promise\Deferred;

class GetBankAccountQueryHandler
{
    /** @var BankAccountFinder */
    private $bankAccountFinder;

    public function __construct(BankAccountFinder $bankAccountFinder)
    {
        $this->bankAccountFinder = $bankAccountFinder;
    }

    public function __invoke(GetBankAccountQuery $bankAccountCommand, Deferred $deferred = null)
    {
        $bankAccount = $this->bankAccountFinder->findByAccountNumber(
            $bankAccountCommand->bankAccountNumber()->toString()
        );
        if (null === $deferred) {
            return $bankAccount;
        }

        $deferred->resolve($bankAccount);
    }
}