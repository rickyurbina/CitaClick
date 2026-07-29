<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ColaboradorController extends Controller
{
    public function citasIndex()
    {
        return view('colaborador.citas.index');
    }
}