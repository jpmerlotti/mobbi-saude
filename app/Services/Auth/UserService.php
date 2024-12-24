<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Services\Service;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserService extends Service
{
    private function validate(array $data = [], string $context): void
    {
        $rules = match ($context) {
            'update' => [],

            'password' => [],
        };

        $messages = [];
        $validation = Validator::make($data, $rules, $messages);

        if ($validation->fails()) {
            throw new ValidationException($validation);
        }
    }

    public function update(User $user, array $data): User
    {
        if (! empty($data['name']) && $user->name !== $data['name']) {
            $user->name = $data['name'];
        }

        if (! empty($data['email']) && $user->email !== $data['email']) {

            if (User::where('email', $data['email'])->exists()) {
                throw new \Exception('Email já existe'); // @codeCoverageIgnore
            }

            $user->email = $data['email'];
        }

        $user->save();

        return $user;
    }

    /**
     * @throws \Exception
     */
    public function updatePassword(User $user, array $data): User
    {
        if (! password_verify($data['old_password'], $user->password)) {
            throw new \Exception('A senha atual não confere a senha do usuário'); // @codeCoverageIgnore
        }

        if (password_verify($data['new_password'], $user->password)) {
            throw new \Exception('A nova senha é a mesma da antiga'); // @codeCoverageIgnore
        }

        $user->update(['password' => $data['new_password']]);

        return $user;
    }
}
