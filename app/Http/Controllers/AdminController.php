<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function negociosIndex()
    {
        return view('admin.negocios.index');
    }

    public function negociosCreate()
    {
        return view('admin.negocios.create');
    }

    public function serviciosIndex()
    {
        return view('admin.servicios.index');
    }
}