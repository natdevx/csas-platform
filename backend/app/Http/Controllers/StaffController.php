<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Listar staff (admins y profesores)
     */
    public function index()
    {
        $staff = User::whereHas('roles', function ($q) {
            $q->whereIn('name', ['admin','professor']);
        })->with('staff')->paginate(20);

        return response()->json([
            'success' => true,
            'data'    => $staff
        ]);
    }

    /**
     * Mostrar un staff por ID
     */
    public function show($id)
    {
        $staff = User::with('staff')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $staff
        ]);
    }

    /**
     * Actualizar staff (user + staff + rol)
     */
    public function update(Request $request, $id)
    {
        $staff = User::with('staff')->findOrFail($id);

        $validated = $request->validate([
            'name'          => 'sometimes|string|max:100',
            'first_surname' => 'sometimes|string|max:255',
            'email'         => "sometimes|email|unique:users,email,{$id}",
            'password'      => 'nullable|string|min:8',
            'staff_type'    => 'sometimes|in:admin,professor',
            'department'    => 'nullable|string|max:120',
            'employee_id'   => "nullable|string|max:50|unique:staff,employee_id," . ($staff->staff->id ?? 'NULL') . ",id",
            'academic_rank' => 'nullable|string|max:80',
        ]);

        // Actualizar usuario
        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }
        $staff->update($validated);

        // Actualizar datos de staff
        if ($staff->staff) {
            $staff->staff->update($request->only([
                'staff_type','department','employee_id','academic_rank'
            ]));
        }

        // Actualizar rol si cambió
        if ($request->filled('staff_type')) {
            $staff->syncRoles([$request->input('staff_type')]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Staff actualizado correctamente',
            'data'    => $staff->load('staff')
        ]);
    }

    /**
     * Eliminar staff (user + staff)
     */
    public function destroy($id)
    {
        $staff = User::findOrFail($id);
        $staff->delete();

        return response()->json([
            'success' => true,
            'message' => 'Staff eliminado correctamente'
        ]);
    }
}

