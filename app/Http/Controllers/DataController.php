<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Role;

class DataController extends Controller
{
    use HttpResponses;

    public function gender(){

        $male = UserDetail::where('gender','male')->count();
        $female = UserDetail::where('gender','female')->count();
 

        return $this->success([ 'male' => $male, 'female' => $female]);

    }


    public function age(){

        $under_30 =  UserDetail::where('age','<',30)->count();
        $from_31_to_40 =  UserDetail::whereBetween('age', [31, 40])->count();
        $from_41_to_50 =  UserDetail::whereBetween('age', [41, 50])->count();
        $above_50 =  UserDetail::where('age','>',30)->count();
 
 

        return $this->success([ '< 30' => $under_30, '31-40' => $from_31_to_40 , '41-50' => $from_41_to_50 , '> 50' => $above_50 ]);

    }

    public function roles(){

        $roles = Role::get();
        return $this->success([  'roles' => $roles ]);

    }
}
