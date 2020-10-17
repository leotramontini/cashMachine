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
     * @throws \App\Exceptions\UserServiceException
     */
    public function store(array $userData)
    {
        $this->user->fill($userData);
        $this->user->save();
        return $this->user;
    }
}
