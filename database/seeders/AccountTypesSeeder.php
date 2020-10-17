<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Support\AccountTypeSupport;

class AccountTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(AccountTypeSupport::getAllTypes() as $status) {
            DB::table('account_types')->insert($status);
        }
    }
}
