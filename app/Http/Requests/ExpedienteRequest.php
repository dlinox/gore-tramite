<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExpedienteRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // 'expe_codigo' => 'nullable|unique:expedientes,expe_codigo,' . $this->get('expediente'),
            'destinatarios' => 'required|array|min:1',
            'destinatarios.*.ofic_id' => 'required|integer',
            'destinatarios.*.para' => 'required|array|min:1',
            'destinatarios.*.para.*' => 'required|integer',

            'expe_archivo' => 'required|array',
            'expe_archivo.*' => 'file|mimes:pdf|max:2048',
            'expe_anexos' => 'required|array',
            'expe_anexos.*' => 'file|mimes:pdf|max:2048',

            'expe_codigo' => 'nullable|unique:expedientes,expe_codigo',
            'expe_password' => 'nullable|string|max:10',
            'expe_origen' => 'boolean',
            'expe_numero' => [
                'required',
                'integer',
                Rule::unique('expedientes')->where(function ($query) {
                    return $query->where('expe_origen', $this->input('expe_origen'))
                        ->where('expe_tipo',  strtoupper($this->input('expe_tipo')))
                        ->where('expe_periodo', $this->input('expe_periodo'))
                        ->where('expe_sigla', $this->input('expe_sigla'))
                        ->where('expe_docu_id', $this->input('expe_docu_id'));
                }),
            ],
            'expe_periodo' => 'required|string|max:4',
            'expe_sigla' => 'required|string|max:20',
            'expe_tipo' => 'required|in:JEFATURA,PERSONAL,EXTERNO,TUPA',
            'expe_asunto' => 'required|string|max:200',
            'expe_resumen' => 'nullable|string',
            'expe_folios' => 'nullable|integer',
            'expe_observacion' => 'nullable|string',
            'expe_fecha_registro' => 'required|date',
            'expe_plazo' => 'nullable|integer',
            'expe_remi_tipo' => 'required|in:NATURAL,JURIDICA',
            'expe_esta_id' => 'required|exists:estados,esta_id',
            'expe_proc_id' => 'required|exists:procesos,proc_id',
            'expe_docu_id' => 'required|exists:documentos,docu_id',
            'expe_admin_id' => 'nullable|exists:admins,id',
            'expe_pers_id' => 'nullable|exists:personas,pers_id',
        ];
    }

    public function messages()
    {

        $maxSizeInMB = $this->getMaxSizeInMB();
        return [
            'expe_codigo.unique' => 'El código del expediente ya está en uso.',
            'expe_password.required' => 'El campo contraseña es obligatorio.',
            'expe_password.max' => 'La contraseña no debe exceder los :max caracteres.',
            'expe_origen.boolean' => 'El campo origen debe ser un valor booleano.',

            'expe_numero.required' => 'El número es obligatorio.',
            'expe_numero.integer' => 'El número debe ser un valor entero.',
            'expe_numero.unique' => 'El número ya esta en uso.',

            'expe_periodo.required' => 'El campo período es obligatorio.',
            'expe_periodo.max' => 'El campo período no debe exceder los :max caracteres.',
            'expe_sigla.required' => 'El campo sigla es obligatorio.',
            'expe_sigla.max' => 'La sigla no debe exceder los :max caracteres.',
            'expe_tipo.required' => 'El campo tipo es obligatorio.',
            'expe_tipo.in' => 'El campo tipo tiene un valor inválido.',
            'expe_asunto.required' => 'El campo asunto es obligatorio.',
            'expe_asunto.max' => 'El campo asunto no debe exceder los :max caracteres.',
            'expe_resumen.max' => 'El campo resumen no debe exceder los :max caracteres.',
            'expe_folios.integer' => 'El campo folios debe ser un valor entero.',
            'expe_observacion.max' => 'El campo observación no debe exceder los :max caracteres.',
            'expe_fecha_registro.required' => 'La fecha es obligatoria.',
            'expe_fecha_registro.date' => 'El campo fecha de registro debe ser una fecha válida.',
            'expe_plazo.integer' => 'El campo plazo debe ser un valor entero.',
            'expe_remi_tipo.required' => 'El campo tipo de remitente es obligatorio.',
            'expe_remi_tipo.in' => 'El campo tipo de remitente tiene un valor inválido.',
            'expe_esta_id.required' => 'El campo ID de estado es obligatorio.',
            'expe_esta_id.exists' => 'El ID de estado especificado no existe.',
            'expe_proc_id.required' => 'El campo ID de proceso es obligatorio.',
            'expe_proc_id.exists' => 'El ID de proceso especificado no existe.',
            'expe_docu_id.required' => 'El campo ID de documento es obligatorio.',
            'expe_docu_id.exists' => 'El ID de documento especificado no existe.',
            'expe_admin_id.exists' => 'El ID de administrador especificado no existe.',
            'expe_pers_id.required' => 'El campo ID de persona es obligatorio.',
            'expe_pers_id.exists' => 'El ID de persona especificado no existe.',


            'destinatarios.required' => 'El campo destinatarios es obligatorio.',
            'destinatarios.array' => 'El campo destinatarios debe ser un array.',
            'destinatarios.min' => 'El campo destinatarios debe tener al menos :min elemento(s).',
            'destinatarios.*.ofic_id.required' => 'El campo ofic_id en destinatarios es obligatorio.',
            'destinatarios.*.ofic_id.integer' => 'El campo ofic_id en destinatarios debe ser un entero.',
            'destinatarios.*.para.required' => 'Seleccione al menos un destinatario.',
            'destinatarios.*.para.array' => 'El campo para en destinatarios debe ser un array.',
            'destinatarios.*.para.min' => 'El campo para en destinatarios debe tener al menos :min elemento(s).',
            'destinatarios.*.para.*.required' => 'Seleccione almenos un destinatario.',
            'destinatarios.*.para.*.integer' => 'El campo para en destinatarios debe contener solo valores enteros.',


            'expe_archivo.required' => 'El campo archivo es requerido.',
            'expe_archivo.array' => 'El campo archivo debe ser un arreglo.',
            'expe_archivo.*.file' => 'El campo archivo debe ser un archivo.',
            'expe_archivo.*.mimes' => 'El campo archivo debe ser un archivo de tipo: :values.',
            'expe_archivo.*.max' => "Excede los :max  MB.",
            'expe_anexos.required' => 'El campo anexos es requerido.',
            'expe_anexos.array' => 'El campo anexos debe ser un arreglo.',
            'expe_anexos.*.file' => 'El campo anexos debe ser un archivo.',
            'expe_anexos.*.mimes' => 'El campo anexos debe ser un archivo de tipo: :values.',
            'expe_anexos.*.max' => "Excede los :max MB.",

        ];
    }


    private function getMaxSizeInMB()
    {
        $maxSizeInBytes = 2048; // Reemplaza YourFileSizeInBytes con el tamaño máximo en bytes que desees
        $maxSizeInMB = $maxSizeInBytes / 1024; // Convierte a MB

        return $maxSizeInMB;
    }
}
