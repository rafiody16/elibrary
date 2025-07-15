<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class Register extends Component
{
    public $name, $email, $password, $password_confirmation, $id_role;

    public function register()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'id_role' => 'required|integer|exists:roles,id_role',
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'id_role' => $this->id_role,
        ]);

        session()->flash('message', 'Registration successful!');
        return redirect()->route('login');

    }

    public function render()
    {
        return view('livewire.auth.register', [
            'roles' => Role::all(),
        ]);
    }

}
