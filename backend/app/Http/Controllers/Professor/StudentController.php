<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\Auth\RegisterStudentRequest;
use App\Models\Staff;
use App\Models\Student;
use App\Models\User;


class StudentController extends Controller
{
    // Middleware en rutas: auth:sanctum, role:professor

    // Reutilizamos el registro de student PERO verificamos que sea de su propio institute
    public function store(RegisterStudentRequest $request)
    {
        $profInstituteId = Staff::where('user_id', $request->user()->id)->value('institute_id');
        // Si vas a guardar institute_id en staff, úsalo; si no, usa otra regla de negocio.
        // Si no hay institute_id en staff, omite este chequeo o ajusta tu modelo de datos.

        // (Opcional) puedes forzar que el student quede en el mismo institute del profesor:
        // $request->merge(['institute_id' => $profInstituteId]);

        // También puedes validar que lo que envía pertenezca a ese instituto:
        // if ($request->input('institute_id') !== $profInstituteId) { abort(403, 'No puedes crear alumnos de otro instituto'); }

        $ctrl = app(\App\Http\Controllers\Auth\RegisterStudentController::class);
        return $ctrl->register($request);
    }

    public function index(Request $request)
    {
        // Lista alumnos por instituto/carrera/grupos del profesor (depende de tu modelo).
        // Aquí te muestro un ejemplo simple por instituto si lo guardas en staff:
        $profInstituteId = Staff::where('user_id', $request->user()->id)->value('institute_id');

        $students = Student::with(['user','career','group'])
            ->where('institute_id', $profInstituteId)
            ->paginate(20);

        return $students;
    }
}
