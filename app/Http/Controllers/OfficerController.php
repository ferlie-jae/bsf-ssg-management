<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuration\Position;

class OfficerController extends Controller
{
    public function index()
    {
        $data = [
            'positions' => Position::get()
        ];
        return view('officers', $data);
    }
}
