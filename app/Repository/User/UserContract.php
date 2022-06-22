<?php

namespace App\Repository\User;

use Exception;
use App\Models\User;

interface UserContract
{
    /**
     * Get user by id
     * @param  int  $id
     * @return mixed
     */
    public function getById(int $id):User;

    /**
     * authenticate user.
     *
     * @param  string  $email
     * @param  string  $password
     * @return mixed
     */
    public function login(string $email, string $password);

    /**
     * register new user
     * @param $data
     * @return User|Exception
     */
    public function create($data): User|Exception;

    /**
     * update user.
     * @param  int  $id
     * @param  array  $data
     * @return User
     */
    public function update(int $id, array $data): User;
}