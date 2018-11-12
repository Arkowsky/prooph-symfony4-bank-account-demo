<?php

declare(strict_types = 1);

namespace App\DTO;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     shortName="transaction",
 *     collectionOperations={
 *          "get"={
 *              "method"="GET",
 *              "path"="/transactions",
 *              "normalization_context"={"groups"={"get"}},
 *              "swagger_context": {
 *                  "parameters": {
 *                     { "name": "bankAccountNumber", "in": "query", "type": "string" }
 *                  }
 *              }
 *          },
 *          "post"={
 *              "method"="POST",
 *              "path"="/transactions",
 *              "normalization_context"={"groups"={"get_posted"}}
 *          },
 *     },
 *     itemOperations={
 *          "get"={
 *              "method"="GET",
 *              "path"="/transactions/{id}",
 *              "requirements"={"number"="\s+"},
 *              "normalization_context"={"groups"={"get"}},
 *          }
 *     },
 *     attributes={
 *          "normalization_context"={"groups"={"get", "get_posted"}},
 *          "denormalization_context"={"groups"={"post"}}
 *     }
 * )
 *
 */
class Transaction
{
    /**
     * @var UuidInterface
     * @ApiProperty(identifier=true)
     * @Groups({"get", "get_posted"})
     */
    private $transactionId;

    /**
     * @var string
     * @ApiProperty()
     * @Groups({"post", "get"})
     */
    private $bankAccountNumber;

    /**
     * @var float
     * @ApiProperty()
     * @Groups({"post", "get", "get_posted"})
     */
    private $amount;

    /**
     * @var string
     * @ApiProperty()
     * @Groups({"post", "get", "get_posted"})
     */
    private $currency;

    /**
     * @var float
     * @ApiProperty()
     * @Groups({"get"})
     */
    private $balanceAfterTransaction;

    /**
     * @return UuidInterface
     */
    public function getTransactionId(): UuidInterface
    {
        return $this->transactionId;
    }

    /**
     * @param UuidInterface $transactionId
     * @return Transaction
     */
    public function setTransactionId(UuidInterface $transactionId): Transaction
    {
        $this->transactionId = $transactionId;
        return $this;
    }

    /**
     * @return string
     */
    public function getBankAccountNumber(): string
    {
        return $this->bankAccountNumber;
    }

    /**
     * @param string $bankAccountNumber
     * @return Transaction
     */
    public function setBankAccountNumber(string $bankAccountNumber): Transaction
    {
        $this->bankAccountNumber = $bankAccountNumber;
        return $this;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     * @return Transaction
     */
    public function setAmount(float $amount): Transaction
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     * @return Transaction
     */
    public function setCurrency(string $currency): Transaction
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return float
     */
    public function getBalanceAfterTransaction(): float
    {
        return $this->balanceAfterTransaction;
    }

    /**
     * @param float $balanceAfterTransaction
     * @return Transaction
     */
    public function setBalanceAfterTransaction(float $balanceAfterTransaction): Transaction
    {
        $this->balanceAfterTransaction = $balanceAfterTransaction;
        return $this;
    }
}