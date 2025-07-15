<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Role as Roles;

class Role extends Component
{
    public $roles, $name_role, $description, $id_role, $showRoleModal = false;

    public function render()
    {
        $this->roles = Roles::all();
        return view('livewire.role.role', [
            'roles' => $this->roles
        ]);
    }

    protected $listeners = [
        'deleteRoleListener' => 'deleteRole',
    ];

    protected $rules = [
        'name_role' => 'required|string|max:255',
        'description' => 'nullable|string|max:500',
    ];

    public function resetFields()
    {
        $this->name_role = '';
        $this->description = '';
        $this->id_role = null;
    }

    public function addRole()
    {
        $this->resetFields();
        $this->showRoleModal = true;
    }

    public function storeRole()
    {
        $this->validate();
        try {
             Roles::create([
            'name_role' => $this->name_role,
            'description' => $this->description,
            ]);

            session()->flash('success', 'Role added successfully.');
            $this->resetFields();
            $this->showRoleModal = false;
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to add role: ' . $e->getMessage());
        }
    }

    public function editRole($id)
    {
        $role = Roles::find($id);
        if ($role) {
            $this->name_role = $role->name_role;
            $this->description = $role->description;
            $this->id_role = $role->id_role;
            $this->showRoleModal = true;
        } else {
            session()->flash('error', 'Role not found.');
        }
    }

    public function updateRole()
    {
        $this->validate();
        try {
            $role = Roles::find($this->id_role);
            if ($role) {
                $role->name_role = $this->name_role;
                $role->description = $this->description;
                $role->save();

                session()->flash('message', 'Role updated successfully.');
                $this->resetFields();
                $this->showRoleModal = false;
            } else {
                session()->flash('error', 'Role not found.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update role: ' . $e->getMessage());
        }
    }

    public function cancelPost()
    {
        $this->resetFields();
        $this->showRoleModal = false;
    }

    public function deleteRole($id)
    {
        try {
            $role = Roles::find($id);
            if ($role) {
                $role->delete();
                session()->flash('message', 'Role deleted successfully.');
            } else {
                session()->flash('error', 'Role not found.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete role: ' . $e->getMessage());
        }
    }

    public function closeModal() 
    {
        $this->resetFields();
        $this->showRoleModal = false;
    }

}
