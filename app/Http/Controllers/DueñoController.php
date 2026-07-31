<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DueñoController extends Controller
{
    public function dashboard()
    {
        return view('dueño.dashboard');
    }

    public function citasIndex()
    {
        return view('dueño.citas.index');
    }

    public function serviciosCreate()
    {
        return view('dueño.servicios.create');
    }

    public function colaboradoresCreate()
    {
        return view('dueño.colaboradores.create');
    }
}