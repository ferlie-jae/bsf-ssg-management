<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Achievement;
use App\Models\Election;

class WebsiteController extends Controller
{
    public function index()
    {
        return view('website.index');
    }

    public function visionMission()
    {
        return view('website.vision_mission');
    }

    public function bsfHymn()
    {
        return view('website.bsf_hymn');
    }

    public function history()
    {
        return view('website.history');
    }

    public function contactUs()
    {
        return view('website.contact_us');
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
