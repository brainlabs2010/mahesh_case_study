<?php

namespace App\Repository\User;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\NoAccountFoundException;
use App\Exceptions\InvalidCredentialException;

class UserRepository implements UserContract
{
    private User $user;

    /**
     * @param  User  $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): User
    {
        return $this->user->findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function login(string $email, string $password)
    {
        $user = $this->user->whereEmail($email)->first();
        if (!$user) {
            throw new NoAccountFoundException;
        }

        if (!Hash::check($password, $user->password)) {
            throw new InvalidCredentialException;
        }
        return [
            'user'         => $user,
            'access_token' => $user->createToken($email)->plainTextToken,
        ];
    }

    /**
     * @inheritDoc
     */
    public function create($data): User|Exception
    {
        $data['password'] = bcrypt($data['password']);
        return $this->user->create($data);
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, array $data): User
    {
        $user = $this->getById($id);
        return tap($user)->update($data);
    }
}