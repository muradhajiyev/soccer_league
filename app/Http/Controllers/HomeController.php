<?php

namespace App\Http\Controllers;

use App\League;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $leagues = League::orderBy('id', 'desc')->paginate(10);

        return view('home.index', ['leagues' => $leagues]);
    }
}
