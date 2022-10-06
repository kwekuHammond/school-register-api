<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsersRequest;
use App\Models\users;
use Illuminate\Http\Request;
use Nette\Utils\Json;

use function PHPUnit\Framework\isEmpty;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Users = users::all()->makeHidden(['password']);
        //return json_encode($Users);
        return response()->json([
            'status' => true,
            'messages'=> 'number of records: ' . $Users->count(),
            'data' =>$Users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $usersRequest)
    {
        $usersRequest['password'] = password_hash($usersRequest['password'], null);
        $request = users::create($usersRequest->all());

        return response()->json([
            'status' => true,
            'message' => 'User Added Successfully',
            'user' => $request
        ], 200);
    }

    /**
     * Display the specified resource from search.
     *
     * @param  \App\Models\users  $users
     * @return \Illuminate\Http\Response
     */
    public function search($request)
    {
        $user = users::where('fullname', 'LIKE', '%' . $request . '%')->get()->except(['password']);

            return response()->json([
                'status' => true,
                'message' =>'Number of users found: ' .  $user->count(),
                'user' => $user
            ], 200);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\users  $users
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = users::findorFail($id);

        return response()->json([
            'status' => true,
            'message' => 'User Updated Successfully',
            'user' => ['Full Name' => $user->fullname, 'Email' => $user->email]
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\users  $users
     * @return \Illuminate\Http\Response
     */
    public function edit(users $users)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\users  $users
     * @return \Illuminate\Http\Response
     */
    public function update(UsersRequest $request)
    {
        $user = users::find($request->id);
        $request["password"] = password_hash($request["password"], null);
        $user->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'User Updated Successfully',
            'user' => ['Full Name' => $user->fullname, 'Email' => $user->email]
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\users  $users
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = users::find($id);

        if ($user !== null) {
            $user->delete();
            return response()->json([
                'status' => true,
                'message' => 'User Deleted Successfully',
                // 'user' => $user
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'User Not Found',
                // 'user' => $user
            ], 200);
        }
    }
}
