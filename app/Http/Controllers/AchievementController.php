<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use Illuminate\Http\Request;
use Auth;

class AchievementController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permission:achievements.index', ['only' => ['index']]);
		$this->middleware('permission:achievements.create', ['only' => ['create','store']]);
		$this->middleware('permission:achievements.show', ['only' => ['show']]);
		$this->middleware('permission:achievements.edit', ['only' => ['edit','update']]);
        $this->middleware('permission:achievements.destroy', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $achievements = Achievement::select('*');
        $achievements->orderBy('updated_at', 'DESC');

        if(Auth::user()->hasrole('System Administrator')){
            $achievements = $achievements->withTrashed();
        }

        $data = [
            'achievements' => $achievements->get()
        ];

        return view('achievements.index', $data);
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
                'modal_content' => view('achievements.create')->render()
            ]);
        }else{
            return view('achievements.create');
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

        Achievement::create([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
        ]);

        return redirect()->route('achievements.index')->with('alert-success', 'saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Achievement  $achievement
     * @return \Illuminate\Http\Response
     */
    public function show(Achievement $achievement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Achievement  $achievement
     * @return \Illuminate\Http\Response
     */
    public function edit(Achievement $achievement)
    {
        return view('achievements.edit', compact('achievement'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Achievement  $achievement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Achievement $achievement)
    {
        $request->validate([
            'title' => ['required']
        ]);

        $achievement->update([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
        ]);

        return redirect()->route('achievements.index')->with('alert-success', 'saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Achievement  $achievement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Achievement $achievement)
	{
		if (request()->get('permanent')) {
			$achievement->forceDelete();
		}else{
			$achievement->delete();
		}
		return redirect()->route('achievements.index')->with('alert-danger','Deleted');
	}

	public function restore($achievement)
	{
		$achievement = Achievement::withTrashed()->find($achievement);
		$achievement->restore();
		return redirect()->route('achievements.index')->with('alert-success','Restored');
	}
}
