<?php

namespace App\Http\Controllers;

use Adldap\Laravel\Facades\Adldap;

class tests extends Controller
{
    public function index()
    {
            $username='riemann';

            $param =  1;

        return view('test', compact('param'));
    }

}
