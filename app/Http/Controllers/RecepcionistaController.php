<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecepcionistaController extends Controller
{
    public function colaboradoresIndex()
    {
        return view('recepcionista.colaboradores.index');
    }
}