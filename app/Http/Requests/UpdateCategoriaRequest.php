<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoriaRequest extends FormRequest
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
        if ($categoria = $this->route('categorium')) {
            $Id = $categoria->caracteristica->id;
        }
        if ($marca = $this->route('marca')) {
            $Id = $marca->caracteristica->id;
        }
        if ($presentacion = $this->route('presentacion')) {
            $Id = $presentacion->caracteristica->id;
        }

        return [
            'nombre' => 'required|max:60|unique:caracteristicas,nombre,' . $Id,
            'descripcion' => 'nullable|max:255'
        ];
    }
}
