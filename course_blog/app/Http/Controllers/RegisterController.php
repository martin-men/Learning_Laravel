<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        return view('register.create');
    }

    public function store(): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        // Create the user
        // If validation fails for any field, you will be redirected to the previous page
        // If validation succeeds, it returns the values as an array
        $attributes = request()->validate([
            'name' => 'required|max:255',
            'username' => 'required|max:255|min:3|unique:users,username', // To indicate that this field is unique we provide unique:tableName,columnName
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:7|max:255'
        ]);

        // Eloquent mutator to hash the password before storing it in the DB (at User model)
        $user = User::create($attributes);

        // Flash messages
        session()->flash('success', 'Your account has been created.');

        // Log the user in
        auth()->login($user);

        return redirect('/');
    }
}
