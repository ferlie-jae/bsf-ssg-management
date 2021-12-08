<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuration\Position;
use App\Models\Achievement;

class PageController extends Controller
{
    public function visionMission()
    {
        return view('welcome');
    }

    public function achievements()
    {
        $achievements = Achievement::select('*');

        $data = [
            'achievements' => $achievements->get()
        ];

        return view('achievements.index', $data);
    }

    public function officers()
    {
        $data = [
            'positions' => Position::get()
        ];
        return view('students.officers', $data);
    }
}
