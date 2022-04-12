<?php

namespace Aggregate\Contracts;

use JsonSerializable;

interface Arrayable extends JsonSerializable
{
    /**
     * @return array
     */
    public function toArray(): array;
}
