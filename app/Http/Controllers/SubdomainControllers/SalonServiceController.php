<?php

namespace App\Http\Controllers\SubdomainControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SalonServiceController extends Controller
{
    public function index()
    {
        return view('salon-subdomain.services');
    }
}
