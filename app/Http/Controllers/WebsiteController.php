<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Achievement;
use App\Models\Announcement;
use App\Models\Election;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUsMail;

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

    public function submitContactUs(Request $request)
    {
        Mail::to(config('mail.from.address'))->send(new ContactUsMail($request));

        return back()->with('alert-success', 'Message Send');
    }

    public function campusOfficials()
    {
        return view('website.campus_officials');
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
        $achievements = Achievement::orderBy('created_at', 'DESC')->get();

        $data = [
            'achievements' => $achievements
        ];
        
        return view('website.achievements', $data);
    }

    public function campusNews()
    {
        $announcements = Announcement::orderBy('created_at', 'DESC')->get();

        $data = [
            'announcements' => $announcements
        ];
        
        return view('website.campus_news', $data);
    }

    public function coursesOffered()
    {
        return view('website.courses_offered');
    }

    public function enrollmentProcedure()
    {
        return view('website.enrollment_procedure');
    }
}
