<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Http\Requests\Auth\RegisterStaffRequest;
use Illuminate\Support\Facades\DB;


class RegisterStaffController extends Controller
{
    public function register(RegisterStaffRequest $request)
    {
        // 1. Crear usuario base en `users`
        $user = User::create([
            'name'          => $request->name,
            'first_surname' => $request->first_surname,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
        ]);

        // 2. Crear staff (profesor o admin)
        $staff = Staff::create([
            'user_id'       => $user->id,
            'institute_id'  => $request->institute_id,
            'staff_type'    => $request->staff_type,   // "admin" o "professor"
            'gender'        => $request->gender,
            'department'    => $request->department,
            'employee_id'   => $request->employee_id,
            'academic_rank' => $request->academic_rank,
        ]);

        // 3. Asignar rol al usuario
        $user->assignRole($request->staff_type); // usando Spatie roles

        // 4. Crear token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'role'  => $request->staff_type,
            'user'  => $user,
            'staff' => $staff
        ], 201);
    }
}
