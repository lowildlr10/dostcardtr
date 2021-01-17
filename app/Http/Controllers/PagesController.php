<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Agency;

class PagesController extends Controller
{
    protected $agency;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->agency = Agency::where('is_set', 'y')->first();
    }

    public function index(){
        return view('pages.index', ['agency' => $this->agency]);
    }
}
