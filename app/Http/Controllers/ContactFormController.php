<?php

namespace App\Http\Controllers;

class ContactFormController extends Controller
{

    public function index()
    {
        return view('contact-form', []);
    }
}
