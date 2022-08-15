<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\CabinetRepo;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public $cabinet;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CabinetRepo $cabinet)
    {
        $this->middleware('auth');
        $this->cabinet = $cabinet;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $cabinets = $this->cabinet->getAllCabinets();
        return view('home',compact('cabinets'));
    }
}
