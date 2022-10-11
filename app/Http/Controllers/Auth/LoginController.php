<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

//Modelos necesarios

class LoginController extends Controller
{
    //accion par amostar el formulario del login
    public function form(){
        return view('auth.login');
    }
}