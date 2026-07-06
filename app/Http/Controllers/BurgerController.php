<?php

namespace App\Http\Controllers;

use App\Models\Burger;
use Illuminate\Http\Request;

class BurgerController extends Controller
{
    // Exibe a página inicial com todos os hambúrgueres
    public function index()
    {
        $burgers = Burger::latest()->get();
        return view('welcome', compact('burgers'));
    }
}
