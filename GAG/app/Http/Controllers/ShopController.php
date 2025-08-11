<?php

namespace App\Http\Controllers;

use App\Models\Pet;

class ShopController extends Controller
{
    public function index()
    {
        $pets = Pet::all();
        return view('shop.app', compact('pets'));
    }
}
