<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->can('role-create') || auth()->user()->can('role-update');
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'permission' => 'required',
        ];
    }
}
