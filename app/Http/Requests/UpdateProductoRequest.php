<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductoRequest extends FormRequest
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
        $producto = $this->route('producto');

        return [
            'codigo' => 'max:50|required|unique:productos,codigo,' . $producto->id,
            'nombre' => 'max:80|required|unique:productos,nombre,' . $producto->id,
            'descripcion' => 'nullable|max:255',
            'fecha_vencimiento' => 'nullable|date',
            'img_path' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'marca_id' => 'required|integer|exists:marcas,id',
            'presentacion_id' => 'required|integer|exists:presentaciones,id',
            'categorias' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'descripcion' => 'descripción',
            'fecha_vencimiento' => 'fecha vencimiento',
            'img_path' => 'imagen',
            'marca_id' => 'marca',
            'presentacion_id' => 'presentación',

        ];
    }
}
