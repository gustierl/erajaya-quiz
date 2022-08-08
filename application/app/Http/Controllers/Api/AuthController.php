<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $rules  = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed'],
            'role'=>['required']

        ];
        $message = [
            'name.required'=>'Nama harus diisi',
            'name.string'=>'Nama harus berupa karakter',
            'name.max'=>'Nama maks.  255 karakter',
            'email.required'=>'Email harus diisi',
            'email.email'=>'Email tidak valid',
            'email.max'=>'Email maks. 255 karakter',
            'email.unique'=>'Email sudah terdaftar',
            'password.required'=>'Password harus diisi',
            'password.confirmed'=>'Pasword tidak cocok',
            'role.required'=>'Role harus diisi',
        ];
        $validator = Validator::make($request->all(),$rules,$message);
        if ($validator->passes()) {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ];
            $user = User::create($data);
            $user->attachRole($request->role);
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json(['status'=>'success','access_token' => $token,'token_type' => 'Bearer']);
        } else {
            return response()->json(['status'=>'success','message'=>$validator->errors()]);
        }
        
        
    }

    public function login(Request $request){
        if (!Auth::attempt($request->only('email', 'password'))) {
               return response()->json([
                'message' => 'Login information is invalid.'
              ], 401);
        }
 
        $user = User::where('email', $request['email'])->firstOrFail();
                $token = $user->createToken('authToken')->plainTextToken;
 
            return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            ]);
    }
}
