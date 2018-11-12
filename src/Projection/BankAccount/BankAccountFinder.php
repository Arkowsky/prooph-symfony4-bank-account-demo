<?php

declare(strict_types=1);

namespace App\Projection\BankAccount;

use App\Projection\Table;
use Doctrine\DBAL\Connection;

class BankAccountFinder
{
    /**
     * @var Connection
     */
    private $connection;
    /**
     * @var BankAccountRecordTransformerInterface
     */
    private $transformer;

    public function __construct(Connection $connection, BankAccountRecordTransformerInterface $transformer)
    {
        $this->connection = $connection;
        $this->transformer = $transformer;
    }

    public function findByAccountNumber(string $bankAccountNumber)
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->select('*')
            ->from(Table::BANK_ACCOUNT)
            ->where('number = :bankAccountNumber')
            ->setParameter('bankAccountNumber', $bankAccountNumber);

        $smt = $queryBuilder->execute();

        $bankAccountRecord = $smt->fetch();

        return $bankAccountRecord ? $this->transformer->toDTO($bankAccountRecord) : null;
    }
}