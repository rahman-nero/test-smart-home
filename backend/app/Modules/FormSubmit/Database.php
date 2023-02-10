<?php

namespace App\Modules\FormSubmit;

use App\Modules\FormSubmit\Contracts\SenderContract;

final class Database implements SenderContract
{

    public function handle(string $name, string $telephone, string $message): bool
    {
        // TODO: Implement handle() method.
    }
}
