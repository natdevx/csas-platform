<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Institute;

class InstituteController extends Controller
{
    public function index()
    {
        return Institute::orderBy('name')->paginate(20);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:150',
            'type'     => 'required|in:university,highschool',
            'location' => 'nullable|string|max:255',
        ]);

        return Institute::create($data);
    }

    public function show(Institute $institute)
    {
        return $institute->load('careers');
    }

    public function update(Request $request, Institute $institute)
    {
        $data = $request->validate([
            'name'     => 'sometimes|string|max:150',
            'type'     => 'sometimes|in:university,highschool',
            'location' => 'nullable|string|max:255',
        ]);
        $institute->update($data);
        return $institute;
    }

    public function destroy(Institute $institute)
    {
        $institute->delete();
        return response()->json(['message' => 'Institute deleted']);
    }
}
