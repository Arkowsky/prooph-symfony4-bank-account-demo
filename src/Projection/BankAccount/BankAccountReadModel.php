<?php

declare(strict_types=1);

namespace App\Projection\BankAccount;

use App\Projection\ReadModelTrait;
use App\Projection\Table;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;
use Prooph\EventStore\Projection\AbstractReadModel;

final class BankAccountReadModel extends AbstractReadModel
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
        $table = $schema->createTable(Table::BANK_ACCOUNT);
        $table->addColumn('number', Type::STRING, ['length' => 30, 'notnull' => true]);
        $table->addColumn('owner_name', Type::STRING, ['length' => 36, 'notnull' => true]);
        $table->addColumn('current_balance', Type::DECIMAL, ['precision' => 10, 'scale' => 2, 'notnull' => true]);
        $table->addColumn('currency', TYPE::STRING, ['length' => 3, 'notnull' => true]);
        $table->addColumn('last_update', Type::DATETIME, ['notnull' => true]);
        $table->setPrimaryKey(['number']);

        return $schema;
    }

    public function isInitialized(): bool
    {
        $tableName = Table::BANK_ACCOUNT;

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
        $tableName = Table::BANK_ACCOUNT;
        $sql = "TRUNCATE TABLE $tableName;";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
    }

    public function delete(): void
    {
        $tableName = Table::BANK_ACCOUNT;
        $sql = "DROP TABLE $tableName;";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
    }

    protected function insert(array $data): void
    {
        $this->connection->insert(Table::BANK_ACCOUNT, $data);
    }

    protected function update(array $data, array $identifier): void
    {
        $this->connection->update(
            Table::BANK_ACCOUNT,
            $data,
            $identifier
        );
    }
}