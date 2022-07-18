<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function show(){
        
        $users = new User();
        $users = $users->get();
        return $users;


    }

    public function update(Request $request,$id){
        $user = new User();
        $user = $user->find($id);
        $user->session = $request->e_session;
        $user->update();
        return $user;
    }

    public function store(Request $request){

        $user = new User();
        $user->session = $request->session;
        $user->password =Hash::make($request->password);
        $user->status = $request->status;
        $user->type = 100;
 
        if($user->save()){
            return response()->json([
                'msg' => 200,
            ]);
        }
    }

    public function login(Request $request)
    {

        $session = $request->validate([
            'session' => ['required'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($session)) {
            return response()->json([
                Auth::user(),
                'msg' => 'Information Correct'
            ]);
        }
        else{
            return response()->json([
                'msg' => 'Information Incorrect'
            ]);
        }

    }

    public function logout(){

        Auth::logout();
    }

    
}
