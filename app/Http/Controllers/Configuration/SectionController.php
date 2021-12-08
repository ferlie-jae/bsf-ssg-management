<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use App\Models\Configuration\Section;
use Illuminate\Http\Request;
use Auth;


class SectionController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permission:sections.index', ['only' => ['index']]);
		$this->middleware('permission:sections.create', ['only' => ['create','store']]);
		$this->middleware('permission:sections.show', ['only' => ['show']]);
		$this->middleware('permission:sections.edit', ['only' => ['edit','update']]);
		$this->middleware('permission:sections.destroy', ['only' => ['destroy']]);
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::select('*');
        if(Auth::user()->hasrole('System Administrator')){
			$sections->withTrashed();
		}
        $data = [
            'sections' => $sections->get()
        ];
        
		return view('configuration.sections.index', $data);
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
				'modal_content' => view('configuration.sections.create')->render()
			]);
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
			'grade_level' => 'required',
			'name' => 'required',
		]);

		Section::create([
			'grade_level' => $request->get('grade_level'),
			'name' => $request->get('name')
        ]);
        
		return back()->with('alert-success', 'Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Configuration\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        $data = ([
			'section' => $section,
		]);
		/* if(!Auth::user()->hasrole('System Administrator')){
			$data = ([
				'section' => $section,
			]);
		} */

		return response()->json([
			'modal_content' => view('configuration.sections.show', $data)->render()
		]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Configuration\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        $data = ([
			'section' => $section
		]);
		return response()->json([
			'modal_content' => view('configuration.sections.edit', $data)->render()
		]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Configuration\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Section $section)
    {
        $request->validate([
			'grade_level' => 'required',
			'name' => 'required',
		]);

		$section->update([
			'grade_level' => $request->get('grade_level'),
			'name' => $request->get('name')
        ]);

		return redirect()->route('sections.index')
					->with('alert-success', 'Saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Configuration\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        if (request()->get('permanent')) {
            if(Auth::user()->hasrole('System Administrator')){
                $section->forceDelete();
            }
		}else{
			$section->delete();
		}
		return redirect()->route('sections.index')
						->with('alert-danger', 'Deleted');
    }

    public function restore($section)
	{
		$section = Section::withTrashed()->find($section);
		$section->restore();
		return redirect()->route('sections.index')
						->with('alert-success', 'Restored');
	}
}
