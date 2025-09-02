<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

use App\Http\Requests\Auth\RegisterStudentRequest;
use Illuminate\Support\Facades\DB;

class RegisterStudentController extends Controller
{
    public function register(RegisterStudentRequest $request)
    {
        // 1. Crear usuario base en `users`
        $user = User::create([
            'name'          => $request->name,
            'first_surname' => $request->first_surname,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
        ]);

        // 2. Crear student
        $student = Student::create([
            'user_id'      => $user->id,
            'institute_id' => $request->institute_id,
            'gender'       => $request->gender,
            'age'          => $request->age,
            'enrollment_id' => $request->enrollment_id,
            'career_id'     => $request->career_id, 
            'group_id'      => $request->group_id,  
        ]);

        // 3. Asignar rol "student"
        $user->assignRole('student');

        // 4. Crear token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token'   => $token,
            'role'    => 'student',
            'user'    => $user,
            'student' => $student
        ], 201);
    }
}
