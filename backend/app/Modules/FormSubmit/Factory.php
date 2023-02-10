<?php

namespace App\Modules\FormSubmit;

use InvalidArgumentException;

final class Factory
{
    public function make(string $type)
    {
        return match ($type) {
            'database' => new Database(),
            'file' => new File(),
            default => throw new InvalidArgumentException()
        };
    }

}
