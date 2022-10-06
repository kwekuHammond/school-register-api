<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsersRequest;
use App\Models\users;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function register(UsersRequest $usersRequest)
    {
        $usersRequest['password'] = password_hash($usersRequest['password'], null);
        $user = users::create($usersRequest->all());

        $token = $user->createToken('myapptoken')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'User Added Successfully',
            'user' => ['Name'=>$user->fullname, 'Email'=>$user->email, 'Token'=>$token]
        ], 201);
    }
}
