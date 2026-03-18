<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ponente;

class PonenteVistaController extends Controller
{
    public function index(){
        $ponentes=Ponente::all();
        return view('ponentes.vista',compact('ponentes'));
    }
}