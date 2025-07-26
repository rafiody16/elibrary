<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role; 
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('role.index', compact('roles'));
    }

    public function create()
    {
        return view('role.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'name_role' => 'required|string|max:255',
            'description' => 'required|string|max:500',
        ];

        $validate = Validator::make($request->all(), $rules)->validate();

        if (!$validate) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
            ]);
        }

        Role::create([
            'name_role' => $request->name_role,
            'description' => $request->description,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Role created successfully',
        ]);
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('role.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name_role' => 'required|string|max:255',
            'description' => 'required|string|max:500',
        ];

        $validate = Validator::make($request->all(), $rules)->validate();

        if (!$validate) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
            ]);
        }

        $role = Role::findOrFail($id);
        $role->update([
            'name_role' => $request->name_role,
            'description' => $request->description,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Role updated successfully',
        ]);
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return response()->json([
            'success' => true,
            'message' => 'Role deleted successfully',
        ]);
    }

}
