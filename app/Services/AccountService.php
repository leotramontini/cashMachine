<?php


namespace App\Services;


use App\Exceptions\AccountServiceException;
use App\Models\Account;
use App\Support\AccountSupport;
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

    /**
     * @param int $accountId
     * @param int $value
     * @return array
     * @throws \App\Exceptions\AccountServiceException
     */
    public function withdraw(int $accountId, int $value)
    {
        $account = $this->account->find($accountId);

        if (empty($account)) {
            throw new AccountServiceException('Account not found');
        }

        if ($account->balance < $value) {
            throw new AccountServiceException('Value is bigger than account balance');
        }

        $banknotes = $this->getBankNotes($value);

        $account->fill([
            'balance' => $account->balance - $value
        ]);
        $account->save();

        return $banknotes;
    }

    /**
     * @param int $value
     * @return array
     * @throws \App\Exceptions\AccountServiceException
     */
    public function getBankNotes(int $value)
    {
        $allBanknotes = AccountSupport::BANKNOTES;
        arsort($allBanknotes);

        $banknotes = [];
        foreach($allBanknotes as $banknote) {
            if ($value == 0) {
                continue;
            }

            $module = $value % $banknote;

            if ($module < end($allBanknotes) && $module != 0) {
                continue;
            }

            $numberOfBanknote = (int) ($value / $banknote);

            if ($numberOfBanknote == 0) {
                continue;
            }

            $value -= $numberOfBanknote * $banknote;
            $banknotes[$banknote] = $numberOfBanknote;
        }

        if ($value > 0) {
            throw new AccountServiceException('Value compatible with banknotes');
        }

        return $banknotes;
    }
}
