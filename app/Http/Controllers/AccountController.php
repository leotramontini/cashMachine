<?php


namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Services\AccountService;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    protected $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $inputs = $request->all();

        $validator = Validator::make($inputs, [
            'balance'           => 'required|int',
            'account_type_id'   => 'required|int',
            'user_id'           => 'required|int'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => Arr::first($validator->getMessageBag()->getMessages())[0]
            ], 422);
        }

        $account = $this->accountService->store($inputs);

        return response()->json($account);
    }
}
