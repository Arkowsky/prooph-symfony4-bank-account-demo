<?php

namespace App\Api\DataProvider;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use App\Domain\Query\GetTransactionQuery;
use App\DTO\Transaction;
use Prooph\ServiceBus\QueryBus;

class TransactionDataItemProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
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
     * @param int|string $id
     *
     * @throws ResourceClassNotSupportedException
     *
     * @return object|null
     */
    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        $promise = $this->queryBus->dispatch(new GetTransactionQuery(
            [
                'transactionId' => $id
            ]
        ));

        $promise->then(function ($result) use (&$receivedMessage): void {
            $receivedMessage = $result;
        });

        return $receivedMessage;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Transaction::class === $resourceClass;
    }
}