<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\Auth\RegisterStaffRequest;
use App\Http\Requests\Auth\RegisterStudentRequest;
use App\Models\Student;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    // Lista de usuarios con paginación
    public function index()
    {
        $users = User::with(['roles', 'student', 'staff'])->paginate(20);

        return response()->json([
            'success' => true,
            'message' => 'Lista de usuarios obtenida correctamente',
            'data'    => $users
        ]);
    }

    // Mostrar un usuario
    public function show(User $user)
    {
        return response()->json([
            'success' => true,
            'message' => 'Usuario encontrado',
            'data'    => $user->load(['roles', 'student', 'staff'])
        ]);
    }

    // Crear STUDENT
    public function storeStudent(RegisterStudentRequest $request)
    {
        $ctrl = app(\App\Http\Controllers\Auth\RegisterStudentController::class);
        return $ctrl->register($request);
    }

    // Crear STAFF
    public function storeStaff(RegisterStaffRequest $request)
    {
        $ctrl = app(\App\Http\Controllers\Auth\RegisterStaffController::class);
        return $ctrl->register($request);
    }

    // Actualizar usuario
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'            => 'sometimes|string|max:100',
            'first_surname'   => 'sometimes|string|max:255',
            'second_lastname' => 'nullable|string|max:255',
            'email'           => "sometimes|email|unique:users,email,{$user->id}",
            'password'        => 'nullable|string|min:8',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Usuario actualizado correctamente',
            'data'    => $user->load(['roles', 'student', 'staff'])
        ]);
    }

    // Eliminar usuario
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Usuario eliminado correctamente'
        ]);
    }
}
