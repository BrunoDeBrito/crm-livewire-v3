<?php

namespace App\Support\Table;

/**
 * @class Column
 * @author BrunoDeBrito @email <brunordebrito@gmail.com>
 * @since 8/17/26 22:38
 * @version 1.0.0
 *
 */
readonly class Header
{
    public function __construct(
        public string $key,
        public string $label,
    ) {
    }

    public static function make(string $key, string $label): self
    {
        return new self($key, $label);
    }
}
