<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gene;
use Illuminate\Support\Facades\URL;

class tests extends Controller
{
    public function index()
    {

            $urlPlusKey = URL::current();
            $urlArray = explode('/', $urlPlusKey);
            $param = end($urlArray);

        return view('test', compact('param'));
    }

}
