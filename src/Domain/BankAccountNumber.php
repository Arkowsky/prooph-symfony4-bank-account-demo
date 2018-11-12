<?php

declare(strict_types=1);

namespace App\Domain;

class BankAccountNumber implements ValueObject
{
    /** @var string */
    private $bankAccountNumber;

    protected function __construct(string $bankAccountNumber)
    {
        $this->bankAccountNumber = $bankAccountNumber;
    }

    static public function fromString(string $bankAccountNumber): self
    {
        return new self($bankAccountNumber);
    }

    static public function generateNew(): self
    {
        // @TODO: just for presentation purposes
        $bankAccountNumber = 'PL' . str_pad(
            (string)rand(0,9999999999) . (string)rand(0,9999999999) . (string)rand(0,999999),
                26,
                '0'
        );

        return new self($bankAccountNumber);
    }

    public function toString()
    {
        return $this->bankAccountNumber;
    }

    public function sameValueAs(ValueObject $otherObject)
    {
        return get_class($this) === get_class($otherObject) && ($this->bankAccountNumber === $otherObject->bankAccountNumber);
    }
}