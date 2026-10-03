<?php

namespace App\Livewire\SuperAdmin;

use App\Models\EmpresasModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class FormularioEmpresa extends Component
{
    use WithFileUploads;

    public $empresaId = null;
    public $modo = 'crear';

    public $nombre = '';
    public $emailContacto = '';
    public $telefono = '';
    public $plan = 'basico';
    public $estatus = 'prueba';
    public $logoUrl = '';
    public $logoFile = null;
    public $fechaVencimiento = '';

    public $cargando = false;
    public $mostrarModal = false;
    public $logoExistente = null;

    protected $listeners = [
        'abrir-crear-empresa' => 'abrirCrear',
        'abrir-editar-empresa' => 'abrirEditar',
        'cerrar-formulario-empresa' => 'cerrarModal',
    ];

    public function abrirCrear()
    {
        $this->resetFormulario();
        $this->modo = 'crear';
        $this->empresaId = null;
        $this->logoExistente = null;
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
        $this->logoUrl = $empresa->getRawOriginal('logo_url');
        $this->logoExistente = $empresa->getRawOriginal('logo_url');
        $this->fechaVencimiento = $empresa->fecha_vencimiento ? $empresa->fecha_vencimiento->format('Y-m-d') : '';
        $this->logoFile = null;

        $this->mostrarModal = true;
        $this->dispatch('modal-abierto');
    }

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
            'logoFile' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,gif,svg,webp',
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
            'logoFile.image' => 'El archivo debe ser una imagen.',
            'logoFile.max' => 'La imagen no puede pesar más de 2MB.',
            'logoFile.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg, gif, svg, webp.',
            'fechaVencimiento.date' => 'Ingresa una fecha válida.',
            'fechaVencimiento.after' => 'La fecha de vencimiento debe ser posterior a hoy.',
        ];
    }

    public function guardar()
    {
        $this->validate();

        $this->cargando = true;

        try {
            DB::beginTransaction();

            // Manejar correctamente el logo
            $logoPath = null;

            // 1. Si se subió un archivo nuevo, guardarlo
            if ($this->logoFile) {
                // Si existe un logo anterior, eliminarlo
                if ($this->logoExistente && $this->modo === 'editar') {
                    $this->eliminarLogoAnterior($this->normalizarRutaStorage($this->logoExistente));
                }
                $logoPath = $this->guardarLogo($this->logoFile);
            } 
            // 2. Si no se subió archivo, mantener el logo existente
            else {
                $logoPath = $this->normalizarRutaStorage($this->logoExistente);
            }

            $datos = [
                'nombre' => $this->nombre,
                'email_contacto' => $this->emailContacto,
                'telefono' => $this->telefono,
                'plan' => $this->plan,
                'estatus' => $this->estatus,
                'logo_url' => $logoPath,
                'fecha_vencimiento' => $this->fechaVencimiento ?: null,
            ];

            if ($this->modo === 'editar') {
                $empresa = EmpresasModel::findOrFail($this->empresaId);
                $empresa->update($datos);
                
                // 👈 LOG PARA DEBUG
                Log::info('Logo guardado:', [
                    'empresa' => $empresa->nombre,
                    'logo_path' => $logoPath,
                    'logo_file' => $this->logoFile ? 'Subido' : 'No subido',
                    'logo_existente' => $this->logoExistente,
                ]);
                
                $mensaje = 'Empresa actualizada correctamente.';
                $tipo = 'success';
            } else {
                $datos['slug'] = $this->generarSlug($this->nombre);
                EmpresasModel::create($datos);
                $mensaje = 'Empresa creada correctamente.';
                $tipo = 'success';
            }

            DB::commit();

            $this->dispatch('empresa-guardada', mensaje: $mensaje, tipo: $tipo);
            $this->cerrarModal();

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Si hubo error y se subió un logo, eliminarlo
            if ($this->logoFile && isset($logoPath)) {
                Storage::disk('public')->delete($logoPath);
            }

            $this->dispatch('mostrar-mensaje', 
                mensaje: 'Ocurrió un error al guardar la empresa: ' . $e->getMessage(),
                tipo: 'error'
            );
        }

        $this->cargando = false;
    }

    protected function guardarLogo($file)
    {
        $nombre = Str::slug($this->nombre) . '-' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('logos', $nombre, 'public');
        return $path;
    }

    protected function normalizarRutaStorage(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            $path = parse_url($path, PHP_URL_PATH) ?: $path;
        }

        $path = str_replace('\\', '/', $path);

        if (str_starts_with($path, '/storage/')) {
            $path = substr($path, 9);
        } elseif (str_starts_with($path, 'storage/')) {
            $path = substr($path, 8);
        }

        return ltrim($path, '/') ?: null;
    }

    protected function eliminarLogoAnterior($path)
    {
        $path = $this->normalizarRutaStorage($path);
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    protected function generarSlug($nombre)
    {
        $slug = Str::slug($nombre) . '-' . Str::random(4);
        
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
        $this->logoFile = null;
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
        $this->logoFile = null;
        $this->logoExistente = null;
        $this->fechaVencimiento = '';
        $this->empresaId = null;
        $this->modo = 'crear';
    }

    public function render()
    {
        return view('livewire.superadmin.formulario-empresa');
    }
}