<?php

namespace App\Api\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use App\Domain\Query\GetBankAccountTransactionsQuery;
use App\Domain\Query\GetBankAccountTransactionsQueryHandler;
use App\DTO\Transaction;
use Symfony\Component\HttpFoundation\RequestStack;

class TransactionCollectionDataProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{
    /**
     * @var GetBankAccountTransactionsQueryHandler
     */
    private $commandHandler;
    /**
     * @var RequestStack
     */
    private $requestStack;

    function __construct(
        GetBankAccountTransactionsQueryHandler $commandHandler,
        RequestStack $requestStack
    )
    {
        $this->commandHandler = $commandHandler;
        $this->requestStack = $requestStack;
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
        return $this->commandHandler->handle(new GetBankAccountTransactionsQuery(
            [
                'bankAccountNumber' => $this->requestStack->getCurrentRequest()->get('bankAccountNumber')
            ]
        ));
    }
}