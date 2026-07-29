<?php

namespace App\Http\Controllers;

use App\Models\EmpresasModel;
use Illuminate\Http\Request;

class BarberiaController extends Controller
{
    public function showCliente(string $slug)
    {
        $empresa = EmpresasModel::where('slug', $slug)->first();

        if (!$empresa) {
            abort(404, 'La página que buscas no existe.');
        }

        return view('citas', compact('empresa'));
    }

    public function showRecepcion(string $slug)
    {
        $empresa = EmpresasModel::where('slug', $slug)->first();

        if (!$empresa) {
            abort(404, 'La página que buscas no existe.');
        }

        return view('gestion-colaboradores', compact('empresa'));
    }
}
