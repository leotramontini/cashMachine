<?php


namespace App\Services;


use App\Exceptions\AccountServiceException;
use App\Models\Account;
use Illuminate\Support\Arr;

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

    /**
     * @param array $inputs
     * @param int $accountId
     * @return \App\Models\Account
     * @throws \App\Exceptions\AccountServiceException
     */
    public function deposit(array $inputs, int $accountId)
    {
        $account = $this->account->find($accountId);

        if (empty($account)) {
            throw new AccountServiceException('Account not found');
        }

        $account->fill([
            'balance'  => ($account->balance + Arr::get($inputs, 'value'))
        ]);
        $account->save();

        return $account;
    }
}
