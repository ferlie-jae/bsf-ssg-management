<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Achievement;
use App\Models\Announcement;
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

    public function campusOfficials()
    {
        
    }

    public function ssgOfficials()
    {
        $elections = Election::orderBy('created_at', 'DESC')->get();
        $data = [
            'elections' => $elections
        ];
        return view('website.ssg_officials', $data);
    }
    
    public function achievements()
    {
        $achievements = Achievement::select('*');

        $data = [
            'achievements' => $achievements->get()
        ];

        return view('achievements.index', $data);
    }

    public function campusNews()
    {
        $announcements = Announcement::orderBy('created_at', 'DESC')->get();

        $data = [
            'announcements' => $announcements
        ];
        
        return view('website.campus_news', $data);
    }
}
