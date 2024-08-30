<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\services\MailchimpNewsletter;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    // Laravel can automatically instantiate an object from a class if the syntax is the following
    public function __invoke(MailchimpNewsletter $newsletter): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        request()->validate(['email' => 'required|email']);

        try {
            $newsletter->subscribe(request('email'));
        } catch (\Exception $e) {
            \Illuminate\Validation\ValidationException::withMessages([
                'email' => 'This email could not be added to our newsletter´s list'
            ]);
        }

        return redirect('/')->with('success', 'You are now signed up for our newsletter!');
    }
}
