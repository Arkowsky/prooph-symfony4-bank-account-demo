<?php

namespace App\Domain;

interface ValueObject
{
    public function sameValueAs(ValueObject $otherObject);
}