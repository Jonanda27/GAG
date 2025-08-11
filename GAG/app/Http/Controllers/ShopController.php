<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Testi;

class ShopController extends Controller
{
    public function index()
    {
        $pets = Pet::all();
        $testis = Testi::all();
        return view('shop.app', compact('pets','testis'));
    }
}
