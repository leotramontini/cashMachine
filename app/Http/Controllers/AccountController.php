<?php


namespace App\Http\Controllers;

use App\Exceptions\AccountServiceException;
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

    /**
     * @param \Illuminate\Http\Request $request
     * @param int $accountId
     * @return \Illuminate\Http\JsonResponse
     */
    public function deposit(Request $request, int $accountId)
    {
        $inputs = $request->all();

        $validator = Validator::make($inputs, [
            'value' => 'required|int|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => Arr::first($validator->getMessageBag()->getMessages())[0]
            ], 422);
        }

        try {
            $account = $this->accountService->deposit($inputs, $accountId);
        } catch (AccountServiceException $error) {
            return response()->json([
                'message' => $error->getMessage()
            ], 400);
        }

        return response()->json($account);
    }
}
