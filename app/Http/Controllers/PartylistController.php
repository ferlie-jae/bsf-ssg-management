<?php

namespace App\Http\Controllers;

use App\Models\Partylist;
use Illuminate\Http\Request;

class PartylistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partylists = Partylist::select('*');
        $data = [
            'partylists' => $partylists->get()
        ];
        return view('partylists.index', $data);
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
                'modal_content' => view('partylists.create')->render()
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
            'name' => 'required',
            'color' => 'required',
        ]);

        Partylist::create([
            'name' => $request->get('name'),
            'color' => $request->get('color'),
        ]);

        return redirect()->route('partylists.index')->with('alert-success', 'saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Partylist  $partylist
     * @return \Illuminate\Http\Response
     */
    public function show(Partylist $partylist)
    {
        if(request()->ajax()){
            return response()->json([
                'modal_content' => view('partylists.show', compact('partylist'))->render()
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Partylist  $partylist
     * @return \Illuminate\Http\Response
     */
    public function edit(Partylist $partylist)
    {
        if(request()->ajax()){
            return response()->json([
                'modal_content' => view('partylists.edit', compact('partylist'))->render()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Partylist  $partylist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Partylist $partylist)
    {
        $request->validate([
            'name' => 'required',
            'color' => 'required',
        ]);

        $partylist->update([
            'name' => $request->get('name'),
            'color' => $request->get('color'),
        ]);

        return redirect()->route('partylists.index')->with('alert-success', 'saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Partylist  $partylist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Partylist $partylist)
	{
		if (request()->get('permanent')) {
			$partylist->forceDelete();
		}else{
			$partylist->delete();
		}
		return redirect()->route('partylists.index')
						->with('alert-danger','Deleted');
	}

	public function restore($partylist)
	{
		$partylist = Partylist::withTrashed()->find($partylist);
        $partylist->restore();
		return redirect()->route('partylists.index')
						->with('alert-success','Restored');
	}
}
