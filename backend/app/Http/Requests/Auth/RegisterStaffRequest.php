<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterStaffRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'            => 'required|string|max:100',
            'first_surname'   => 'required|string|max:255',
            'second_lastname' => 'nullable|string|max:255',
            'email'           => 'required|email:rfc,dns|unique:users,email',
            'password'        => 'required|string|min:8|confirmed',

            'staff_type'      => 'required|in:professor,admin',
            'gender'          => 'required|in:male,female,other',
            'department'      => 'nullable|string|max:120',
            'employee_id'     => 'nullable|string|max:50|unique:staff,employee_id',
            'academic_rank'   => 'nullable|string|max:80',
        ];
    }
}
