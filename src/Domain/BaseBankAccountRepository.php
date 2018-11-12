<?php

declare(strict_types=1);

namespace App\Domain;

interface BaseBankAccountRepository
{
    public function save(BankAccount $bankAccount): void;
    public function get(BankAccountNumber $bankAccountNumber): ?BankAccount;
}