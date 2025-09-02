<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Career;

class CareerController extends Controller
{
    public function index(Request $request)
    {
        $q = Career::query()->with('institute');
        if ($request->filled('institute_id')) {
            $q->where('institute_id', $request->institute_id);
        }
        return $q->orderBy('name')->paginate(20);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'institute_id' => 'required|exists:institutes,id',
            'name'         => 'required|string|max:150',
            'level'        => 'required|in:undergraduate,graduate,other',
        ]);
        return Career::create($data);
    }

    public function show(Career $career)   { return $career->load('groups'); }

    public function update(Request $request, Career $career)
    {
        $data = $request->validate([
            'institute_id' => 'sometimes|exists:institutes,id',
            'name'         => 'sometimes|string|max:150',
            'level'        => 'sometimes|in:undergraduate,graduate,other',
        ]);
        $career->update($data);
        return $career;
    }

    public function destroy(Career $career)
    {
        $career->delete();
        return response()->json(['message' => 'Career deleted']);
    }
}
