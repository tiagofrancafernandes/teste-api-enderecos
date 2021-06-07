<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function welcome(Request $request)
    {
        $random_address = Address::inRandomOrder()->first();

        return view('welcome', [
            'random_address' => $random_address ?? null,
        ]);
    }
}
