<?php


namespace App\Services;


use App\Models\Account;

class AccountService
{
    /**
     * @var \App\Models\Account
     */
    protected $account;

    /**
     * AccountService constructor.
     * @param \App\Models\Account $account
     */
    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    /**
     * @param array $inputs
     * @return \App\Models\Account
     */
    public function store(array $inputs)
    {
        $this->account->fill($inputs);
        $this->account->save();
        return $this->account;
    }
}
