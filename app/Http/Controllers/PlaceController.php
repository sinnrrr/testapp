<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;

class PlaceController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @param $id
     * @return Renderable
     */
    public function index($id)
    {
        return view('place', ['id' => $id]);
    }
}
