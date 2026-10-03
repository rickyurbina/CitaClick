<?php

namespace App\Livewire\Cliente;

use App\Models\EmpresasModel;
use App\Models\ClientesModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RegistroCliente extends Component
{
    public EmpresasModel $empresa;
    public string $telefono = '';
    public string $nombre = '';
    public ?string $fechaNacimiento = null;
    public bool $cargando = false;
    public bool $aceptaTerminos = false;

    protected $rules = [
        'nombre' => 'required|string|max:100|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
        'telefono' => 'required|string|max:20',
        'fechaNacimiento' => 'required|date|before:today|after:1900-01-01',
        'aceptaTerminos' => 'accepted',
    ];

    protected $messages = [
        'nombre.required' => 'El nombre completo es obligatorio.',
        'nombre.regex' => 'El nombre solo puede contener letras y espacios.',
        'nombre.max' => 'El nombre no puede exceder los 100 caracteres.',
        'telefono.required' => 'El número de teléfono es obligatorio.',
        'fechaNacimiento.required' => 'La fecha de nacimiento es obligatoria.',
        'fechaNacimiento.date' => 'Ingresa una fecha válida.',
        'fechaNacimiento.before' => 'La fecha debe ser anterior a hoy.',
        'fechaNacimiento.after' => 'La fecha debe ser posterior a 1900.',
        'aceptaTerminos.accepted' => 'Debes aceptar los términos y condiciones.',
    ];

    public function mount($telefono = null)
    {
        if ($telefono) {
            $this->telefono = $telefono;
        }
    }

    public function registrar()
    {
        $this->validate();

        $this->cargando = true;

        try {
            DB::beginTransaction();

            $existe = ClientesModel::where('empresa_id', $this->empresa->id)
                ->where('telefono', $this->telefono)
                ->exists();

            if ($existe) {
                $this->dispatch('mostrar-mensaje', 
                    mensaje: 'Ya existe un cliente con este número de teléfono.',
                    tipo: 'error'
                );
                $this->cargando = false;
                return;
            }

            $cliente = ClientesModel::create([
                'empresa_id' => $this->empresa->id,
                'telefono' => $this->telefono,
                'nombre' => $this->nombre,
                'fecha_nacimiento' => Carbon::parse($this->fechaNacimiento),
                'puntos_buenos' => 0,
                'puntos_malos' => 0,
                'total_gastado' => 0,
            ]);

            DB::commit();

            $this->dispatch('cliente-registrado', 
                clienteId: $cliente->id,
                telefono: $this->telefono
            );

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('mostrar-mensaje', 
                mensaje: 'Ocurrió un error al registrar el cliente. Intenta nuevamente.',
                tipo: 'error'
            );
        }

        $this->cargando = false;
    }

    public function volver()
    {
        $this->dispatch('volver-a-verificar');
    }

    public function render()
    {
        return view('livewire.cliente.registro-cliente');
    }
}