<?php

namespace App\Modules\FormSubmit\Contracts;


interface SenderContract
{
    public function handle(string $name, string $telephone, string $message): bool;
}
