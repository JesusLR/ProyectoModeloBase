<?php

namespace App\Http\Controllers;

class ManualController extends Controller
{

    public function index(){
        return response()->file(resource_path('assets/pdf/Completo.pdf'));
    }

}
