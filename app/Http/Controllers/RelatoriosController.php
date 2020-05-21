<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RelatoriosController extends Controller
{


    public function workDay(Request $request)
    {
        return view('sistema.relatorios.workDay');
    }


}
