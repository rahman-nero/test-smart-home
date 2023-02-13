<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Database\Eloquent\Model;

final class UserService
{
    private Hasher $hasher;

    public function __construct(Hasher $hasher)
    {
        $this->hasher = $hasher;
    }

    /**
     * Создание нового пользователя
     *
     * @param string $name
     * @param string $email
     * @param string $password
     * @return Model
     */
    public function create(string $name, string $email, string $password): Model
    {
        return User::query()
            ->create([
                'name' => $name,
                'email' => $email,
                'password' => $this->hasher->make($password)
            ]);
    }

    /**
     * Проверка введенного email и пароль
     *
     * Используется для авторизации пользователя
     *
     * @param string $email
     * @param string $password
     * @return Model|false
     */
    public function loginCheck(string $email, string $password): Model|false
    {
        $user = User::query()
            ->where('email', '=', $email)
            ->first();

        if (!$user || !$this->hasher->check($password, $user->password)) {
            return false;
        }

        return $user;
    }

}
