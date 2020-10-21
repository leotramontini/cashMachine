<?php

namespace Tests\Unit\Support;

use App\Support\AccountTypeSupport;
use Tests\TestCase;

class AccountTypeSupportTest extends TestCase
{
    public function testGetAllAccountTypes()
    {
        $expected = [
            [
                'name'  => 'Conta poupança',
                'alias' => AccountTypeSupport::SAVINGS_ACCOUNT_TYPE
            ],
            [
                'name'  => 'Conta corrent',
                'alias' => AccountTypeSupport::CURRENT_ACCOUNT_TYPE
            ]
        ];

        $this->assertEquals($expected, AccountTypeSupport::getAllTypes());
    }
}
