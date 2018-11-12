<?php

declare(strict_types=1);

namespace App\Projection\Transaction;

use App\Projection\ReadModelTrait;
use App\Projection\Table;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;
use Prooph\EventStore\Projection\AbstractReadModel;

final class TransactionReadModel extends AbstractReadModel
{
    use ReadModelTrait;

    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    static protected function getSchemaDefinition(): Schema
    {
        $schema = new Schema();
        $table = $schema->createTable(Table::TRANSACTION);
        $table->addColumn('transaction_id', Type::STRING, ['length' => 36, 'notnull' => true]);
        $table->addColumn('bank_account_number', Type::STRING, ['length' => 30, 'notnull' => true]);
        $table->addColumn('amount', Type::DECIMAL, ['precision' => 10, 'scale' => 2, 'notnull' => false]);
        $table->addColumn('currency', TYPE::STRING, ['length' => 3, 'notnull' => true]);
        $table->addColumn('balance_after_transaction', Type::DECIMAL, ['precision' => 10, 'scale' => 2, 'notnull' => false]);
        $table->addColumn('created_at', Type::DATETIME, ['notnull' => true]);
        $table->setPrimaryKey(['transaction_id']);

        return $schema;
    }

    public function isInitialized(): bool
    {
        $tableName = Table::TRANSACTION;

        $sql = "SELECT * FROM pg_catalog.pg_tables WHERE tablename = '$tableName';";

        $statement = $this->connection->prepare($sql);
        $statement->execute();

        $result = $statement->fetch();

        if (false === $result) {
            return false;
        }

        return true;
    }

    public function reset(): void
    {
        $tableName = Table::TRANSACTION;
        $sql = "TRUNCATE TABLE $tableName;";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
    }

    public function delete(): void
    {
        $tableName = Table::TRANSACTION;
        $sql = "DROP TABLE $tableName;";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
    }

    protected function insert(array $data): void
    {
        $this->connection->insert(Table::TRANSACTION, $data);
    }

    protected function update(array $data, array $identifier): void
    {
        $this->connection->update(
            Table::TRANSACTION,
            $data,
            $identifier
        );
    }

    public function remove(array $identifier): void
    {
        $this->connection->delete(
            Table::TRANSACTION,
            $identifier
        );
    }
}