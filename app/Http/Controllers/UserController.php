<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserDetail;

class UserController extends Controller
{
    use HttpResponses;

    public function index(){

        $users = User::with('detail','roles')->get();
        return $this->success([ 'users' => $users]);

    }

    public function store(Request $request){

        //Skip the backend validation for the time-constraint

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password')
         ]);

         UserDetail::create([
            'user_id' => $user->id,
            'age' => $request->age,
            'gender' => $request->gender,
            'phone' => $request->phone
         ]);

         $user->roles()->attach($request->roles);

         return $this->success([]);


    }

    public function edit($id){

        $user = User::with('detail','roles')->findOrFail($id);
        return $this->success([ 'user' => $user]);

        
    }

    public function update(Request $request){

        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $user->detail()->update([ 'age' => $request->age, 'gender' => $request->gender,'phone' => $request->phone]);

        $user->roles()->sync($request->roles);

        return $this->success([]);


    }
}
