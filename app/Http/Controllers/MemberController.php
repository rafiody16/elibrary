<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::all();
        return view('member.index', compact('members'));
    }

    public function create()
    {
        $users = User::all();
        return view('member.create', compact('users'));
    }

    public function store(Request $request)
    {
        $rules = [
            'id_user' => 'required|integer|exists:users,id_user',
            'id_card' => 'required|string|max:20|unique:members,id_card',
            'name_member' => 'required|string|max:50',
            'photo_member' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'required|string|max:255',
            'place_of_birth' => 'required|string|max:50',
            'date_of_birth' => 'required|date',
            'phone' => 'required|string|max:15',
            'job' => 'required|string|max:50',
        ];

        $validate = Validator::make($request->all(), $rules)->validate();

        if (!$validate) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
            ]);
        }

        if ($request->hasFile('photo_member')) {
            $photoPath = $request->file('photo_member')->store('members');
        } else {
            $photoPath = null;
        }

        Member::create([
            'id_user' => $request->id_user,
            'id_card' => Str::upper($request->id_card),
            'name_member' => $request->name_member,
            'photo_member' => $photoPath,
            'address' => $request->address,
            'place_of_birth' => $request->place_of_birth,
            'date_of_birth' => $request->date_of_birth,
            'phone' => $request->phone,
            'job' => $request->job,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Member created successfully',
        ]);
    }

    public function edit($id)
    {
        $member = Member::findOrFail($id);
        $users = User::all();
        return view('member.edit', compact('member', 'users'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'id_user' => 'required|integer|exists:users,id_user',
            'name_member' => 'required|string|max:50',
            'photo_member' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'required|string|max:255',
            'place_of_birth' => 'required|string|max:50',
            'date_of_birth' => 'required|date',
            'phone' => 'required|string|max:15',
            'job' => 'required|string|max:50',
        ];

        $validate = Validator::make($request->all(), $rules)->validate();

        if (!$validate) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
            ]);
        }

        $member = Member::findOrFail($id);

        if ($request->hasFile('photo_member')) {
            if ($member->photo_member) {
                Storage::delete($member->photo_member);
            }
            $photoPath = $request->file('photo_member')->store('members');
        } else {
            $photoPath = $member->photo_member;
        }

        $member->update([
            'id_user' => $request->id_user,
            'name_member' => $request->name_member,
            'photo_member' => $photoPath,
            'address' => $request->address,
            'place_of_birth' => $request->place_of_birth,
            'date_of_birth' => $request->date_of_birth,
            'phone' => $request->phone,
            'job' => $request->job,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Member updated successfully',
        ]);
    }

    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        if ($member->photo_member) {
            Storage::delete($member->photo_member);
        }
        $member->delete();

        return response()->json([
            'success' => true,
            'message' => 'Member deleted successfully',
        ]);
    }
    
}
