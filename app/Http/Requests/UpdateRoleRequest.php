<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
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
        $role = $this->route('role');
        return [
            'name' => 'required|unique:roles,name,' . $role->id,
            'permission' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nombre',
            'permission' => 'permisos',
        ];
    }
}