<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProveedorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'razon_social' => 'required|max:80',
            'direccion' => 'required|max:80',
            'tipo_persona' => 'required|string',
            'documento_id' => 'required|integer|exists:documentos,id',
            'numero_documento' => 'required|max:20|unique:personas,numero_documento'
        ];
    }

    public function attributes()
    {
        return [
            'tipo_persona' => 'tipo de proveedor',
            'razon_social' => 'nombre',
            'direccion' => 'dirección',
            'documento_id' => 'tipo de documento',
            'numero_documento' => 'número de documento'
        ];
    }
}
