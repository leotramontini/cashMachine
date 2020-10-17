<?php

namespace App\Services;

use Exception;
use App\Models\User;
use App\Exceptions\UserServiceException;

class UserService
{
    /**
     * @var \App\Models\User
     */
    protected $user;

    /**
     * UserService constructor.
     * @param \App\Models\User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param array $userData
     * @return \App\Models\User
     */
    public function store(array $userData)
    {
        $this->user->fill($userData);
        $this->user->save();
        return $this->user;
    }

    /**
     * @param int $userId
     * @return int
     * @throws \App\Exceptions\UserServiceException
     */
    public function destroy(int $userId)
    {
        $user = $this->user->find($userId);

        if (empty($user)) {
            throw new UserServiceException('User not found');
        }

        return $user->delete();
    }

    /**
     * @param array $inputs
     * @param int $userId
     * @return \App\Models\User
     * @throws \App\Exceptions\UserServiceException
     */
    public function update(array $inputs, int $userId)
    {
        $user = $this->user->find($userId);

        if (empty($user)) {
            throw new UserServiceException('User not found');
        }

        $user->fill($inputs);
        $user->save();

        return $user;
    }
}
