<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function main()
    {
        return view('pages.main');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function lore()
    {
        return view('pages.lore');
    }
}
