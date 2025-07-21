<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Member as Members;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class Member extends Component
{
    use WithFileUploads;

    public $id_member, $id_card, $id_user, $name_member, $photo_member, $address, $place_of_birth, $date_of_birth, $phone_number, $job, $current_photo, $showModal = false; 

    protected $listeners = [
        'deleteMemberListener' => 'deleteMember',
    ];

    protected $rules = [
        // 'id_user' => 'required|exists:users,id',
        'name_member' => 'required|string|max:255',
        'photo_member' => 'nullable|image|max:2048',
        'address' => 'nullable|string|max:500',
        'place_of_birth' => 'nullable|string|max:100',
        'date_of_birth' => 'nullable|date',
        'phone_number' => 'nullable|string|max:15',
        'job' => 'nullable|string|max:100',
    ];

    protected $rulesUpdate = [
        'id_user' => 'required|exists:users,id',
        'name_member' => 'required|string|max:255',
        'photo_member' => 'nullable|image|max:2048', // Not required for update
        'address' => 'nullable|string|max:500',
        'place_of_birth' => 'nullable|string|max:100',
        'date_of_birth' => 'nullable|date',
        'phone_number' => 'nullable|string|max:15',
        'job' => 'nullable|string|max:100',
    ];

    public function render()
    {
        $members = Members::paginate(10);
        return view('livewire.member.member', compact('members'));
    }

    public function resetFields()
    {
        $this->id_member = null;
        $this->id_user = null;
        $this->name_member = '';
        $this->photo_member = null;
        $this->current_photo = null;
        $this->address = '';
        $this->place_of_birth = '';
        $this->date_of_birth = '';
        $this->phone_number = '';
        $this->job = '';
    }

    public function addMember()
    {
        $this->resetFields();
        $this->showModal = true;
    }

    public function storeMember()
    {
        dd($this->photo_member);
        $this->validate($this->rules);
        try {
            if ($this->photo_member) {
                $coverPath = $this->photo_member->store('members', 'public');
            } else {
                $coverPath = null;
            }

            $data = [
                'id_user' => Auth::id(),
                'id_card' => Str::random(10),
                'name_member' => $this->name_member,
                'address' => $this->address,
                'photo_member' => $coverPath,
                'place_of_birth' => $this->place_of_birth,
                'date_of_birth' => $this->date_of_birth,
                'phone_number' => $this->phone_number,
                'job' => $this->job,
            ];

            Members::create($data);

            session()->flash('success', 'Member added successfully.');
            $this->resetFields();
            $this->showModal = false;
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to add member: ' . $e->getMessage());
        }
    }

    public function editMember($id)
    {
        $member = Members::findOrFail($id);
        $this->id_member = $member->id_member;
        $this->id_user = $member->id_user;
        $this->name_member = $member->name_member;
        $this->current_photo = $member->photo_member;
        $this->address = $member->address;
        $this->place_of_birth = $member->place_of_birth;
        $this->date_of_birth = $member->date_of_birth;
        $this->phone_number = $member->phone_number;
        $this->job = $member->job;
        $this->showModal = true;
    }

    public function updateMember()
    {
        $this->validate($this->rulesUpdate);
        try {
            $member = Members::findOrFail($this->id_member);
            $data = [
                'id_user' => $this->id_user,
                'name_member' => $this->name_member,
                'address' => $this->address,
                'place_of_birth' => $this->place_of_birth,
                'date_of_birth' => $this->date_of_birth,
                'phone_number' => $this->phone_number,
                'job' => $this->job,
            ];

            if ($this->photo_member) {
                if ($this->photo_member && Storage::exists($this->photo_member)) {
                        Storage::delete($this->photo_member);
                    }
                $data['photo_member'] = $this->photo_member->store('members', 'public');
            } else {
                $data['photo_member'] = $this->current_photo; // Keep the existing photo if not updated
            }

            $member->update($data);

            session()->flash('success', 'Member updated successfully.');
            $this->resetFields();
            $this->showModal = false;
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update member: ' . $e->getMessage());
        }
    }

    public function deleteMember($id)
    {
        try {
            $member = Members::findOrFail($id);
            if ($member->photo_member && Storage::exists($member->photo_member)) {
                Storage::delete($member->photo_member);
            }
            $member->delete();

            session()->flash('success', 'Member deleted successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete member: ' . $e->getMessage());
        }
    }

    public function closeModal()
    {
        $this->resetFields();
        $this->showModal = false;
    }
}
