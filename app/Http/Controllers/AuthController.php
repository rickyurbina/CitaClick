<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginCliente()
    {
        return view('auth.login-cliente');
    }

    public function showLoginUsuario()
    {
        return view('auth.login-usuario');
    }

    public function showLoginAdmin()
    {
        return view('auth.login-admin');
    }
}