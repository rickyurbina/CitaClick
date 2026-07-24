<?php

namespace App\Http\Controllers;

use App\Models\EmpresasModel;
use Illuminate\Http\Request;

class BarberiaController extends Controller
{
    public function show(string $slug)
    {
        $empresa = EmpresasModel::where('slug', $slug)->first();

        if (!$empresa) {
            abort(404, 'La página que buscas no existe.');
        }

        return view('empresas.show', compact('empresa'));
    }
}
