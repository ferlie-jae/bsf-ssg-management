<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\UserAnnouncement;
use App\Models\Users;
use App\Models\Configuration\RolePermission\Role;
use Illuminate\Http\Request;
use Auth;

class AnnouncementController extends Controller
{
    public function __construct()
	{
		// $this->middleware('auth');
		$this->middleware('permission:announcements.index', ['only' => ['index']]);
		$this->middleware('permission:announcements.create', ['only' => ['create','store']]);
		$this->middleware('permission:announcements.show', ['only' => ['show']]);
		$this->middleware('permission:announcements.edit', ['only' => ['edit','update']]);
        $this->middleware('permission:announcements.destroy', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $announcements = Announcement::select('*');

        $data = [
            'announcements' => $announcements->get()
        ];

        return view('announcements.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(request()->ajax()){
            return response()->json([
                'modal_content' => view('announcements.create')->render()
            ]);
        }else{
            return view('announcements.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required']
        ]);

        Announcement::create([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
        ]);

        return redirect()->route('announcements.index')->with('alert-success', 'saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function show(Announcement $announcement)
    {
        if(request()->ajax()){
            UserAnnouncement::create([
                'user_id' => Auth::user()->id,
                'announcement_id' => $announcement->id,
            ]);
            $data = [
                'announcement' => $announcement
            ];
            return response()->json([
                'modal_content' => view('announcements.show', $data)->render()
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function edit(Announcement $announcement)
    {
        return view('announcements.edit', compact('announcement'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title' => ['required']
        ]);

        $announcement->update([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
        ]);

        return redirect()->route('announcements.index')->with('alert-success', 'saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Announcement $announcement)
	{
		if (request()->get('permanent')) {
			$announcement->forceDelete();
		}else{
			$announcement->delete();
		}
		return redirect()->route('announcements.index')->with('alert-danger','Deleted');
	}

	public function restore($announcement)
	{
		$announcement = Announcement::withTrashed()->find($announcement);
		$announcement->restore();
		return redirect()->route('announcements.index')->with('alert-success','Restored');
    }
    
    public function notification()
    {
        $user = Auth::user();
        $seen_announcements = UserAnnouncement::where('user_id', $user->id)->get('announcement_id');
        $unseen_announcements = Announcement::whereNotIn('id', $seen_announcements)->get();
        return response()->json([
            'notification' => $unseen_announcements
        ]);
        // $unseen_announcements = 
    }
}
