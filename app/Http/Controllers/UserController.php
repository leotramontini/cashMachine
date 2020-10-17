<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
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
                'message' => Arr::first($validator->getMessageBag()->getMessages())[0]
            ],
                422
            );
        }

        try {
            $user = $this->userService->store($inputs);
        } catch (UserServiceException $error) {
            return response()->json([
                'message' => $error->getMessage()
            ],
                400
            );
        }

        return response()->json($user);
    }

    /**
     * @param int $userIid
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $userIid)
    {
        try {
            $this->userService->destroy($userIid);
        } catch (UserServiceException $error) {
            return response()->json([
                    'message' => $error->getMessage()
                ],
                404
            );
        }

        return response()->json([
            'message' => 'User delete with success'
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param int $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $userId)
    {
        try {
            $user = $this->userService->update($request->all(), $userId);
        } catch (UserServiceException $error) {
            return response()->json([
                'message' => $error->getMessage()
            ],
                404
            );
        }

        return response()->json($user);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $users = $this->userService->index($request->all());
        } catch (UserServiceException $error) {
            return response()->json([
                'message' => $error->getMessage()
            ],
                404
            );
        }

        return response()->json($users);
    }
}
