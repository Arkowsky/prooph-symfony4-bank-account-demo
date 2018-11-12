<?php

declare(strict_types=1);

namespace App\Projection\Transaction;

use App\DTO\Transaction;
use App\Projection\Table;
use Doctrine\DBAL\Connection;

class TransactionFinder
{
    /**
     * @var Connection
     */
    private $connection;
    /**
     * @var TransactionRecordTransformerInterface
     */
    private $transformer;

    public function __construct(Connection $connection, TransactionRecordTransformerInterface $transformer)
    {
        $this->connection = $connection;
        $this->transformer = $transformer;
    }

    public function findAllForBankAccount(
        string $bankAccountNumber
    ): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->select('t.*')
            ->from(Table::TRANSACTION, 't')
            ->where('t.bank_account_number = :bankAccountNumber')
            ->setParameter('bankAccountNumber', $bankAccountNumber);

        $smt = $queryBuilder->execute();

        $transactionRecords = $smt->fetchAll();

        return array_map(function(array $transactionRecord) {
            return $this->transformer->toDTO($transactionRecord);
        }, $transactionRecords);
    }

    public function findByTransactionId(
        string $transactionId
    ): ?Transaction
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->select('t.*')
            ->from(Table::TRANSACTION, 't')
            ->where('transaction_id = :transactionId')
            ->setParameter('transactionId', $transactionId);

        $smt = $queryBuilder->execute();

        $transactionRecord = $smt->fetch();

        return $transactionRecord ? $this->transformer->toDto($transactionRecord) : null;
    }
}