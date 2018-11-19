<?php

declare(strict_types=1);

namespace App\Api\DataProvider;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Domain\BankAccountNumber;
use App\Domain\Query\GetBankAccountQuery;
use App\DTO\BankAccount;
use Prooph\ServiceBus\QueryBus;

class BankAccountDataItemProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    /**
     * @var QueryBus
     */
    private $queryBus;

    function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
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
        $promise = $this->queryBus->dispatch(
            new GetBankAccountQuery([
                    'bankAccountNumber' => BankAccountNumber::fromString($id)
                ]
            )
        );

        $promise->then(function ($result) use (&$receivedMessage): void {
            $receivedMessage = $result;
        });

        return $receivedMessage;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return BankAccount::class === $resourceClass;
    }
}