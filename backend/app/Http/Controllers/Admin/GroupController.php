<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Group;

class GroupController extends Controller
{
   public function index(Request $request)
    {
        $q = Group::query()->with('career');
        if ($request->filled('career_id')) {
            $q->where('career_id', $request->career_id);
        }
        return $q->orderBy('name')->paginate(20);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'career_id'  => 'required|exists:careers,id',
            'name'       => 'required|string|max:25',
            'semester'   => 'required|integer|min:1|max:12',
            'generation' => 'required|digits:4',
        ]);
        return Group::create($data);
    }

    public function show(Group $group)   { return $group; }

    public function update(Request $request, Group $group)
    {
        $data = $request->validate([
            'career_id'  => 'sometimes|exists:careers,id',
            'name'       => 'sometimes|string|max:25',
            'semester'   => 'sometimes|integer|min:1|max:12',
            'generation' => 'sometimes|digits:4',
        ]);
        $group->update($data);
        return $group;
    }

    public function destroy(Group $group)
    {
        $group->delete();
        return response()->json(['message' => 'Group deleted']);
    }
}
