<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
   
    public $email;
    public $password;
    public $title = "login";

    

    public function login() {
        $valid = $this->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        if (!Auth::attempt($valid)) {
            $this->addError('Errors', 'Credentials do not match.');
        } else {
            $user = Auth::user();
            if ($user->role == 'admin' || $user->role == 'owner') {
                $this->redirect(route('home'),true);
            } else {
                $this->addError('Errors', 'You do not have access.');
            }
        }
    }

    public function render()
    {
        return view('livewire.auth.login')->with('title', $this->title);
    }
}