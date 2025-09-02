<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterStudentRequest extends FormRequest
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

            'gender'          => 'required|in:male,female,other',
            'age'             => 'required|integer|min:15|max:120',
            'institute_id'    => 'required|exists:institutes,id',
            'career_id'       => 'required|exists:careers,id',
            'group_id'        => 'required|exists:groups,id',
            'enrollment_id'   => 'required|string|max:55|unique:students,enrollment_id',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($v) {
            // Coherencia: la career pertenece al institute y el group a la career
            $instituteId = $this->input('institute_id');
            $careerId    = $this->input('career_id');
            $groupId     = $this->input('group_id');

            if (\App\Models\Career::where('id',$careerId)->where('institute_id',$instituteId)->doesntExist()) {
                $v->errors()->add('career_id', 'La carrera no pertenece al instituto seleccionado.');
            }
            if (\App\Models\Group::where('id',$groupId)->where('career_id',$careerId)->doesntExist()) {
                $v->errors()->add('group_id', 'El grupo no pertenece a la carrera seleccionada.');
            }
        });
    }
    
}
