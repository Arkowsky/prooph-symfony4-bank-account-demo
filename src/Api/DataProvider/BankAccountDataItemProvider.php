<?php

declare(strict_types=1);

namespace App\Api\DataProvider;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Domain\BankAccountNumber;
use App\Domain\Query\GetBankAccountQuery;
use App\Domain\Query\GetBankAccountQueryHandler;
use App\DTO\BankAccount;

class BankAccountDataItemProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    /**
     * @var GetBankAccountQueryHandler
     */
    private $bankAccountCommandHandler;

    public function __construct(GetBankAccountQueryHandler $bankAccountCommandHandler)
    {
        $this->bankAccountCommandHandler = $bankAccountCommandHandler;
    }

    /**
     * Retrieves an item.
     *
     * @param string $resourceClass
     * @param int|string $id
     *
     * @param string|null $operationName
     * @param array $context
     * @return null|object
     */
    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        return $this->bankAccountCommandHandler->handle(
            new GetBankAccountQuery(
                BankAccountNumber::fromString($id)
            )
        );
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return BankAccount::class === $resourceClass;
    }
}