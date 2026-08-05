<?php

namespace App\Livewire\SuperAdmin;

use App\Models\EmpresasModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;

class FormularioEmpresa extends Component
{
    public $empresaId = null;
    public $modo = 'crear'; // crear | editar

    // Campos del formulario
    public $nombre = '';
    public $emailContacto = '';
    public $telefono = '';
    public $plan = 'basico';
    public $estatus = 'prueba';
    public $logoUrl = '';
    public $fechaVencimiento = '';

    // Estados
    public $cargando = false;
    public $mostrarModal = false;

    protected $listeners = [
        'abrir-crear-empresa' => 'abrirCrear',
        'abrir-editar-empresa' => 'abrirEditar',
        'cerrar-formulario-empresa' => 'cerrarModal',
    ];

    protected function rules()
    {
        $uniqueRule = $this->empresaId 
            ? 'unique:empresas,email_contacto,' . $this->empresaId 
            : 'unique:empresas,email_contacto';

        return [
            'nombre' => 'required|string|max:200',
            'emailContacto' => 'required|email|max:150|' . $uniqueRule,
            'telefono' => 'nullable|string|max:20',
            'plan' => 'required|in:basico,pro,empresa',
            'estatus' => 'required|in:activo,inactivo,prueba,suspendido',
            'logoUrl' => 'nullable|string|max:500|url',
            'fechaVencimiento' => 'nullable|date|after:today',
        ];
    }

    protected function messages()
    {
        return [
            'nombre.required' => 'El nombre de la empresa es obligatorio.',
            'nombre.max' => 'El nombre no puede exceder los 200 caracteres.',
            'emailContacto.required' => 'El email de contacto es obligatorio.',
            'emailContacto.email' => 'Ingresa un email válido.',
            'emailContacto.unique' => 'Este email ya está registrado en otra empresa.',
            'plan.required' => 'Selecciona un plan.',
            'plan.in' => 'El plan seleccionado no es válido.',
            'estatus.required' => 'Selecciona un estatus.',
            'estatus.in' => 'El estatus seleccionado no es válido.',
            'logoUrl.url' => 'La URL del logo no es válida.',
            'fechaVencimiento.date' => 'Ingresa una fecha válida.',
            'fechaVencimiento.after' => 'La fecha de vencimiento debe ser posterior a hoy.',
        ];
    }

    public function abrirCrear()
    {
        $this->resetFormulario();
        $this->modo = 'crear';
        $this->empresaId = null;
        $this->mostrarModal = true;
        $this->dispatch('modal-abierto');
    }

    public function abrirEditar($id)
    {
        $empresa = EmpresasModel::findOrFail($id);

        $this->empresaId = $empresa->id;
        $this->modo = 'editar';
        $this->nombre = $empresa->nombre;
        $this->emailContacto = $empresa->email_contacto;
        $this->telefono = $empresa->telefono;
        $this->plan = $empresa->plan;
        $this->estatus = $empresa->estatus;
        $this->logoUrl = $empresa->logo_url;
        $this->fechaVencimiento = $empresa->fecha_vencimiento ? $empresa->fecha_vencimiento->format('Y-m-d') : '';

        $this->mostrarModal = true;
        $this->dispatch('modal-abierto');
    }

    public function guardar()
    {
        $this->validate();

        $this->cargando = true;

        try {
            DB::beginTransaction();

            $datos = [
                'nombre' => $this->nombre,
                'email_contacto' => $this->emailContacto,
                'telefono' => $this->telefono,
                'plan' => $this->plan,
                'estatus' => $this->estatus,
                'logo_url' => $this->logoUrl ?: null,
                'fecha_vencimiento' => $this->fechaVencimiento ?: null,
            ];

            if ($this->modo === 'editar') {
                // Actualizar empresa
                $empresa = EmpresasModel::findOrFail($this->empresaId);
                $empresa->update($datos);
                $mensaje = 'Empresa actualizada correctamente.';
                $tipo = 'success';
            } else {
                // Crear empresa - Generar slug automático
                $datos['slug'] = $this->generarSlug($this->nombre);
                $empresa = EmpresasModel::create($datos);
                $mensaje = 'Empresa creada correctamente.';
                $tipo = 'success';
            }

            DB::commit();

            $this->dispatch('empresa-guardada', mensaje: $mensaje, tipo: $tipo);
            $this->cerrarModal();

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('mostrar-mensaje', 
                mensaje: 'Ocurrió un error al guardar la empresa: ' . $e->getMessage(),
                tipo: 'error'
            );
        }

        $this->cargando = false;
    }

    protected function generarSlug($nombre)
    {
        $slug = Str::slug($nombre) . '-' . Str::random(4);
        
        // Verificar que no exista
        while (EmpresasModel::where('slug', $slug)->exists()) {
            $slug = Str::slug($nombre) . '-' . Str::random(4);
        }
        
        return $slug;
    }

    public function cerrarModal()
    {
        $this->mostrarModal = false;
        $this->resetFormulario();
        $this->resetErrorBag();
        $this->dispatch('modal-cerrado');
    }

    public function resetFormulario()
    {
        $this->nombre = '';
        $this->emailContacto = '';
        $this->telefono = '';
        $this->plan = 'basico';
        $this->estatus = 'prueba';
        $this->logoUrl = '';
        $this->fechaVencimiento = '';
        $this->empresaId = null;
        $this->modo = 'crear';
    }

    public function render()
    {
        return view('livewire.superadmin.formulario-empresa');
    }
}