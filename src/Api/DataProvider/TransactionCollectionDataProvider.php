<?php

namespace App\Api\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use App\Domain\Query\GetBankAccountTransactionsQuery;
use App\DTO\Transaction;
use Prooph\ServiceBus\QueryBus;
use Symfony\Component\HttpFoundation\RequestStack;

class TransactionCollectionDataProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{
    /**
     * @var RequestStack
     */
    private $requestStack;
    /**
     * @var QueryBus
     */
    private $queryBus;

    function __construct(
        RequestStack $requestStack,
        QueryBus $queryBus
    )
    {
        $this->requestStack = $requestStack;
        $this->queryBus = $queryBus;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Transaction::class === $resourceClass;
    }

    /**
     * Retrieves a collection.
     *
     * @throws ResourceClassNotSupportedException
     *
     * @return array|\Traversable
     */
    public function getCollection(string $resourceClass, string $operationName = null)
    {
        $promise = $this->queryBus->dispatch(new GetBankAccountTransactionsQuery(
            [
                'bankAccountNumber' => $this->requestStack->getCurrentRequest()->get('bankAccountNumber')
            ]
        ));

        $promise->then(function ($result) use (&$receivedMessage): void {
            $receivedMessage = $result;
        });

        return $receivedMessage;
    }
}