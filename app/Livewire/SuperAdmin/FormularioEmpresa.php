<?php

namespace App\Livewire\SuperAdmin;

use App\Models\EmpresasModel;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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

    // Datos de la empresa
    public $nombre = '';
    public $emailContacto = '';
    public $telefono = '';
    public $plan = 'basico';
    public $estatus = 'prueba';
    public $logoUrl = '';
    public $logoFile = null;
    public $fechaVencimiento = '';

    // 👇 Datos del usuario administrador de la empresa (solo creación)
    public $adminNombre = '';
    public $adminEmail = '';
    public $adminPassword = '';
    public $adminPasswordConfirm = '';
    public $adminTelefono = '';

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

        // No cargamos datos del admin en modo edición
        $this->adminNombre = '';
        $this->adminEmail = '';
        $this->adminPassword = '';
        $this->adminPasswordConfirm = '';
        $this->adminTelefono = '';

        $this->mostrarModal = true;
        $this->dispatch('modal-abierto');
    }

    protected function rules()
    {
        $uniqueEmpresa = $this->empresaId
            ? 'unique:empresas,email_contacto,' . $this->empresaId
            : 'unique:empresas,email_contacto';

        $rules = [
            'nombre' => 'required|string|max:200',
            'emailContacto' => 'required|email|max:150|' . $uniqueEmpresa,
            'telefono' => 'nullable|string|max:20',
            'plan' => 'required|in:basico,pro,empresa',
            'estatus' => 'required|in:activo,inactivo,prueba,suspendido',
            'logoFile' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,gif,svg,webp',
            'fechaVencimiento' => 'nullable|date|after:today',
        ];

        // 👇 Reglas del admin solo cuando se está creando
        if ($this->modo === 'crear') {
            $rules['adminNombre']          = 'required|string|max:100';
            $rules['adminEmail']           = 'required|email|max:150|unique:users,email';
            $rules['adminPassword']        = 'required|string|min:6|max:100|same:adminPasswordConfirm';
            $rules['adminPasswordConfirm'] = 'required|string|min:6|max:100';
            $rules['adminTelefono']        = 'nullable|string|max:20';
        }

        return $rules;
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

            // Mensajes del admin
            'adminNombre.required' => 'El nombre del administrador es obligatorio.',
            'adminEmail.required' => 'El email del administrador es obligatorio.',
            'adminEmail.email' => 'Ingresa un email válido para el administrador.',
            'adminEmail.unique' => 'Este email ya está registrado como usuario del sistema.',
            'adminPassword.required' => 'La contraseña del administrador es obligatoria.',
            'adminPassword.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'adminPassword.same' => 'Las contraseñas no coinciden.',
            'adminPasswordConfirm.required' => 'Debes confirmar la contraseña.',
        ];
    }

    public function guardar()
    {
        $this->validate();

        $this->cargando = true;

        try {
            DB::beginTransaction();

            // Manejo del logo
            $logoPath = null;

            if ($this->logoFile) {
                if ($this->logoExistente && $this->modo === 'editar') {
                    $this->eliminarLogoAnterior($this->normalizarRutaStorage($this->logoExistente));
                }
                $logoPath = $this->guardarLogo($this->logoFile);
            } else {
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

                Log::info('Logo guardado:', [
                    'empresa' => $empresa->nombre,
                    'logo_path' => $logoPath,
                    'logo_file' => $this->logoFile ? 'Subido' : 'No subido',
                    'logo_existente' => $this->logoExistente,
                ]);

                $mensaje = 'Empresa actualizada correctamente.';
            } else {
                // 1) Crear la empresa
                $datos['slug'] = $this->generarSlug($this->nombre);
                $empresa = EmpresasModel::create($datos);

                // 2) Crear el usuario administrador de la empresa
                User::create([
                    'empresa_id' => $empresa->id,
                    'nombre'     => $this->adminNombre,
                    'email'      => $this->adminEmail,
                    'password'   => Hash::make($this->adminPassword),
                    'telefono'   => $this->adminTelefono ?: null,
                    'rol'        => 'empresa_admin',
                    'activo'     => true,
                ]);

                $mensaje = 'Empresa y usuario administrador creados correctamente.';
            }

            DB::commit();

            $this->dispatch('empresa-guardada', mensaje: $mensaje, tipo: 'success');
            $this->cerrarModal();

        } catch (\Exception $e) {
            DB::rollBack();

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
        return $file->storeAs('logos', $nombre, 'public');
    }

    protected function normalizarRutaStorage(?string $path): ?string
    {
        if (!$path) return null;

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

        // Limpiar admin
        $this->adminNombre = '';
        $this->adminEmail = '';
        $this->adminPassword = '';
        $this->adminPasswordConfirm = '';
        $this->adminTelefono = '';
    }

    public function render()
    {
        return view('livewire.superadmin.formulario-empresa');
    }
}