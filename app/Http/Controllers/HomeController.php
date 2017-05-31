<?php

namespace App\Http\Controllers;

/**
 * Class HomeController
 *
 * @author  Thomas Wiringa  <thomas.wiringa@gmail.com>
 */
class HomeController extends Controller
{
    /**
     * Index page
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('app');
    }
}