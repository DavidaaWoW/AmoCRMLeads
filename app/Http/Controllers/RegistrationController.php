<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;


class RegistrationController extends Controller
{
    function register(Request $request){
        if (Auth::check()) {
            return redirect(route('leads'));
        }
        $validateFields = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);
        $id = uniqid();
        $validateFields = array('id' => $id) + $validateFields;
        $user = User::create($validateFields);
        if ($user) {
            $remember = $request->only(['remember']);
            Auth::login($user, true);
            return redirect(route('leads'));
        } else {
            return redirect(route('user.login'))->withErrors([
                'formError' => 'Ошибка при аутентификации'
            ]);
        }
    }
}
