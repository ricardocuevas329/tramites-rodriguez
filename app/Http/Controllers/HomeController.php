<?php

namespace App\Http\Controllers;


class HomeController extends Controller
{

    public int $port = 0;
    public function __construct()
    {
       $this->port = request()->getPort();
    }

    public function home()
    {
        return view('app');
    }

    public function externalHome()
    {
        return view('external.app');
    }
}
