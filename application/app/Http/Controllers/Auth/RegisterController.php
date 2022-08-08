<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
     /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function showRegistrationForm ()
    {
        return view('auth.register');
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id'=>['required']
        ],[
            'name.required'=>'Nama harus diisi',
            'name.string'=>'Nama harus berupa karakter',
            'name.max'=>'Nama maks.  255 karakter',
            'email.required'=>'Email harus diisi',
            'email.email'=>'Email tidak valid',
            'email.max'=>'Email maks. 255 karakter',
            'email.unique'=>'Email sudah terdaftar',
            'password.required'=>'Password harus diisi',
            'password.confirmed'=>'Pasword tidak cocok',
            'role_id.required'=>'Role harus diisi',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->attachRole($request->role_id);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
