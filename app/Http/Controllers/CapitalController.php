<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CapitalController extends Controller
{

  public function __construct()
    {
        $this->middleware('auth');
    }

  public function index()
    {
        return view('content.dashboard.dashboards-crm');
    }
}
