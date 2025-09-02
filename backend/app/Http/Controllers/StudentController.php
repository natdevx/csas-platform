<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    // Listar estudiantes
    public function index()
    {
        $students = User::role('student')->get();

        return response()->json([
            'success' => true,
            'message' => 'Lista de estudiantes obtenida correctamente',
            'data'    => $students
        ]);
    }

    // Crear estudiante
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6'
        ]);

        $student = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        $student->assignRole('student');

        return response()->json([
            'success' => true,
            'message' => 'Estudiante creado correctamente',
            'data'    => $student
        ], 201);
    }

    // Actualizar estudiante
    public function update(Request $request, $id)
    {
        $student = User::findOrFail($id);

        $student->update($request->only(['name', 'email']));

        return response()->json([
            'success' => true,
            'message' => 'Estudiante actualizado correctamente',
            'data'    => $student
        ]);
    }

    // Eliminar estudiante
    public function destroy($id)
    {
        $student = User::findOrFail($id);
        $student->delete();

        return response()->json([
            'success' => true,
            'message' => 'Estudiante eliminado correctamente'
        ]);
    }

    // Perfil propio
    public function me()
    {
        return response()->json([
            'success' => true,
            'message' => 'Perfil del estudiante',
            'data'    => Auth::user()
        ]);
    }

    // Actualizar perfil propio
    public function updateMe(Request $request)
    {
        $user = Auth::user();
        $user->update($request->only(['name', 'email']));

        return response()->json([
            'success' => true,
            'message' => 'Perfil actualizado correctamente',
            'data'    => $user
        ]);
    }
}
