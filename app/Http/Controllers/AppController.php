<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends Controller
{
    public function welcomeView()
    {
        return view('welcome');
    }

    public function homeView()
    {
        return view('home');
    }

    public function getUser(Request $request)
    {
        return $request->user();
    }
}
