<?php

declare(strict_types = 1);

namespace App\DTO;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use DateTime;

/**
 * @ApiResource(
 *      shortName="bank_account",
 *      collectionOperations={
 *          "post"={
 *              "method"="POST",
 *              "path"="/bank_account",
 *              "denormalization_context"={"groups"={"post"}},
 *          },
 *      },
 *      itemOperations={
 *          "get"={
 *              "method"="GET",
 *              "path"="/bank_account/{id}",
 *              "normalization_context"={"groups"={"get"}},
 *              "requirements"={"number"="\s+"}
 *          }
 *     },
 *     attributes={
 *          "normalization_context"={"groups"={"get"}},
 *          "denormalization_context"={"groups"={"post", "patch"}}
 *     }
 * )
 */
class BankAccount
{
    /**
     * @var string
     *
     * @ApiProperty(identifier=true)
     * @Groups({"get"})
     */
    private $number;

    /**
     * @var string
     *
     * @ApiProperty()
     * @Groups({"get", "patch", "post"})
     */
    private $ownerName;

    /**
     * @var float
     *
     * @ApiProperty()
     * @Groups({"get"})
     */
    private $currentBalance = 0;

    /**
     * @var string
     *
     * @ApiProperty()
     * @Groups({"get", "post"})
     */
    private $currency;

    /**
     * @var datetime
     * @Groups({"get_list"})
     */
    private $lastUpdate;

    public function __construct(string $ownerName)
    {
        $this->ownerName = $ownerName;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @param string $number
     * @return BankAccount
     */
    public function setNumber(string $number): BankAccount
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return string
     */
    public function getOwnerName(): string
    {
        return $this->ownerName;
    }

    /**
     * @param string $ownerName
     * @return BankAccount
     */
    public function setOwnerName(string $ownerName): BankAccount
    {
        $this->ownerName = $ownerName;
        return $this;
    }

    /**
     * @return float
     */
    public function getCurrentBalance(): float
    {
        return $this->currentBalance;
    }

    /**
     * @param float $currentBalance
     * @return BankAccount
     */
    public function setCurrentBalance(float $currentBalance): BankAccount
    {
        $this->currentBalance = $currentBalance;
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
     * @return BankAccount
     */
    public function setCurrency(string $currency): BankAccount
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getLastUpdate(): DateTime
    {
        return $this->lastUpdate;
    }

    /**
     * @param DateTime $lastUpdate
     * @return BankAccount
     */
    public function setLastUpdate(DateTime $lastUpdate): BankAccount
    {
        $this->lastUpdate = $lastUpdate;
        return $this;
    }
}