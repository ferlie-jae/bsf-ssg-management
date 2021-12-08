<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use App\Models\Configuration\Position;
use Illuminate\Http\Request;
use Auth;

class PositionController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permission:positions.index', ['only' => ['index']]);
		$this->middleware('permission:positions.create', ['only' => ['create','store']]);
		$this->middleware('permission:positions.show', ['only' => ['show']]);
		$this->middleware('permission:positions.edit', ['only' => ['edit','update']]);
		$this->middleware('permission:positions.destroy', ['only' => ['destroy']]);
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $positions = Position::select('*');
        if(Auth::user()->hasrole('System Administrator')){
			$positions->withTrashed();
		}
        $data = [
            'positions' => $positions->get()
        ];
        
		return view('configuration.positions.index', $data);
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
				'modal_content' => view('configuration.positions.create')->render()
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
            'name' => 'required|unique:positions,name',
            'candidate_to_elect' => 'required|integer|gt:0|',
        ]);

        Position::create([
            'name' => $request->get('name'),
            'candidate_to_elect' => $request->get('candidate_to_elect'),
        ]);
        return redirect()->route('positions.show')->with('alert-success', 'Saved');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Configuration\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function show(Position $position)
    {
        $data = ([
			'position_show' => $position,
		]);
		/* if(!Auth::user()->hasrole('System Administrator')){
			$data = ([
				'position' => $position,
			]);
		} */

		return response()->json([
			'modal_content' => view('configuration.positions.show', $data)->render()
		]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Configuration\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function edit(Position $position)
    {
        $data = ([
			'position' => $position
		]);
		return response()->json([
			'modal_content' => view('configuration.positions.edit', $data)->render()
		]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Configuration\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Position $position)
    {
        $request->validate([
			'name' => 'required',
			'candidate_to_elect' => 'required',
		]);

		$position->update([
			'name' => $request->get('name'),
			'candidate_to_elect' => $request->get('candidate_to_elect'),
		]);

		return redirect()->route('positions.index')
					->with('alert-success', 'Saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Configuration\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function destroy(Position $position)
    {
        if (request()->get('permanent')) {
            if(Auth::user()->hasrole('System Administrator')){
                $position->forceDelete();
            }
		}else{
			$position->delete();
		}
		return redirect()->route('positions.index')
						->with('alert-danger', 'Deleted');
    }

    public function restore($position)
	{
		$position = Position::withTrashed()->find($position);
		$position->restore();
		return redirect()->route('positions.index')
						->with('alert-success', 'Restored');
	}
}
