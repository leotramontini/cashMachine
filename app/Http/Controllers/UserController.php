<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Exceptions\UserServiceException;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * @var \App\Services\UserService
     */
    protected $userService;

    /**
     * UserController constructor.
     * @param \App\Services\UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $inputs = $request->all();

        $validator = Validator::make($inputs, [
            'name' => 'required',
            'cpf' => 'required|max:11|min:11',
            'birthday' => 'required|date'
        ]);

        if ($validator->fails()) {
            return response()->json([
                $validator->getMessageBag()
            ], 422);
        }

        $user = $this->userService->store($inputs);
        return response()->json($user);
    }
}
