<?php

namespace App\Api\DataProvider;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use App\Domain\Query\GetTransactionQuery;
use App\Domain\Query\GetTransactionQueryHandler;
use App\DTO\Transaction;

class TransactionDataItemProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    /**
     * @var GetTransactionQueryHandler
     */
    private $commandHandler;

    function __construct(GetTransactionQueryHandler $commandHandler)
    {
        $this->commandHandler = $commandHandler;
    }

    /**
     * Retrieves an item.
     *
     * @param int|string $id
     *
     * @throws ResourceClassNotSupportedException
     *
     * @return object|null
     */
    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        return $this->commandHandler->handle(new GetTransactionQuery(
            [
                'transactionId' => $id
            ]
        ));
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Transaction::class === $resourceClass;
    }
}