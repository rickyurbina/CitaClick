<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function serviciosIndex()
    {
        return view('cliente.servicios.index');
    }

    public function agendarIndex()
    {
        return view('cliente.agendar.index');
    }
}