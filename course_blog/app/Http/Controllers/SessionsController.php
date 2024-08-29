<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SessionsController extends Controller
{
    public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        return view('sessions.create');
    }

    public function destroy(): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        auth()->logout();
        return redirect('/')->with('success', 'Goodbye!');
    }

    /**
     * @throws ValidationException
     */
    public function store(): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        // Attempt to authenticate and login the user
        $attributes =  request()->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);

        if (!auth()->attempt($attributes)) {
            // FIRST APPROACH
//        return back()
//                    ->withInput() // To include old inputs
//                    ->withErrors(['email' => 'Your provided credentials could not be verified']);

            throw ValidationException::withMessages([
                'email' => 'Your provided credentials could not be verified'
            ]);
        }

        // To prevent Session Fixation
        session()->regenerate();

        return redirect('/')->with('success', 'Welcome back!');
    }
}
