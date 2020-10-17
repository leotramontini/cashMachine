<?php


namespace App\Support;


class AccountTypeSupport
{
    /**
     * @const string
     */
    const SAVINGS_ACCOUNT_TYPE = 'savings';

    /**
     * @const string
     */
    const CURRENT_ACCOUNT_TYPE = 'current';

    /**
     * @return array
     */
    public static function getAllTypes()
    {
        return [
            [
                'name'  => 'Conta poupança',
                'alias' => self::SAVINGS_ACCOUNT_TYPE
            ],
            [
                'name'  => 'Conta corrent',
                'alias' => self::CURRENT_ACCOUNT_TYPE
            ]
        ];
    }
}

