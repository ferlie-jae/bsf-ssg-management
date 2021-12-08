<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\Vote;
use Illuminate\Http\Request;
use App\Models\Configuration\Position;
use App\Models\Configuration\Section;
use App\Models\Student;
use App\Models\Candidate;
use App\Models\Partylist;
use App\Charts\OngoingElectionChart;
use App\Charts\ElectionResultPieChart;
use Carbon\Carbon;
use Auth;
use App\Exports\ElectionExport;
use Maatwebsite\Excel\Facades\Excel;

class ElectionController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permission:elections.index', ['only' => ['index']]);
		$this->middleware('permission:elections.create', ['only' => ['create','store']]);
		$this->middleware('permission:elections.show', ['only' => ['show']]);
		$this->middleware('permission:elections.edit', ['only' => ['edit','update']]);
        $this->middleware('permission:elections.destroy', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $elections = Election::select('*');
        if(Auth::user()->hasrole('System Administrator')){
            $elections = $elections->withTrashed();
        }
        $data = [
            'elections' => $elections->get()
        ];

        return view('elections.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = ([
			'positions' => Position::get(),
			'students' => Student::get(),
			'partylists' => Partylist::get(),
		]);
		/* if(!Auth::user()->hasrole('System Administrator')){
			$data = ([
				'faculty' => $faculty,
			]);
        } */
        if(request()->ajax()){
            return response()->json([
                'modal_content' => view('elections.create_ajax', $data)->render()
            ]);
        }else{
            return view('elections.create', $data);
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
			'title' => ['required', 'unique:elections,title'],
            'start_date' => 'required',
            'end_date' => 'required',
            // 'description' => 'required',
        ]);
        
        $now = Carbon::now();
        $start_date = Carbon::parse($request->get('start_date'));
        $end_date = Carbon::parse($request->get('end_date'));
        $status = 'incoming';

        if($start_date->lt($now) && $end_date->gt($now)){
            $status = 'ongoing';
        }
        elseif($end_date->lt($now)){
            $status = 'ended';
        }

        $election = Election::create([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'start_date' => Carbon::parse($request->get('start_date')),
            'end_date' => Carbon::parse($request->get('end_date')),
            'status' => $status
        ]);

        foreach($request->get('candidates') as $position => $candidates){
            foreach($candidates as $index => $candidate){
                if(!is_null($candidate)){
                    Candidate::create([
                        'partylist_id' => $request->get('candidate-partylists')[$position][$index],
                        'student_id' => $candidate,
                        'election_id' => $election->id,
                        'position_id' => $position,
                    ]);
                }
            }
        }

        return redirect()->route('elections.index')->with('alert-success', 'Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Election  $election
     * @return \Illuminate\Http\Response
     */
    public function show(Election $election)
    {
        return view('elections.show', compact('election'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Election  $election
     * @return \Illuminate\Http\Response
     */
    public function edit(Election $election)
    {
        $data = ([
			'positions' => Position::get(),
			'students' => Student::get(),
			'partylists' => Partylist::get(),
			'election' => $election
		]);

		return view('elections.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Election  $election
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Election $election)
    {
        $request->validate([
			'title' => ['required', 'unique:elections,title,'.$election->id],
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
        $now = Carbon::now();
        $start_date = Carbon::parse($request->get('start_date'));
        $end_date = Carbon::parse($request->get('end_date'));
        $status = 'incoming';

        if($start_date->lt($now) && $end_date->gt($now)){
            $status = 'ongoing';
        }
        elseif($end_date->lt($now)){
            $status = 'ended';
        }

        $election->update([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'start_date' => $start_date,
            'end_date' => $end_date,
            'status' => $status
        ]);

        $selectedCandidatesIDs = [];

        foreach($request->get('candidates') as $position => $candidates){
            foreach($candidates as $index => $candidate){
                $query = Candidate::where([
                    ['student_id', $candidate],
                    ['election_id', $election->id],
                    ['position_id', $position],
                ])->doesntExist();
                if($query){
                    Candidate::create([
                        'partylist_id' => $request->get('candidate-partylists')[$position][$index],
                        'student_id' => $candidate,
                        'election_id' => $election->id,
                        'position_id' => $position,
                    ]);
                }
                $selectedCandidatesIDs[] = $candidate;
            }
        }
        $unselectedCandidatesID = Candidate::where([
            ['election_id', $election->id],
        ])->whereNotIn('student_id', $selectedCandidatesIDs)->delete();

        return redirect()->route('elections.show', $election->id)->with('alert-success', 'Saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Election  $election
     * @return \Illuminate\Http\Response
     */
    public function destroy(Election $election)
	{
		if (request()->get('permanent')) {
            Candidate::whereIn('id', $election->candidates->pluck('id'))->forceDelete();
			$election->forceDelete();
		}else{
            Candidate::whereIn('id', $election->candidates->pluck('id'))->delete();
			$election->delete();
		}
		return redirect()->route('elections.index')
						->with('alert-danger','Deleted');
	}

	public function restore($election)
	{
		$election = Election::withTrashed()->find($election);
        $election->restore();
        Candidate::where('election_id', $election->id)->withTrashed()->restore();
		return redirect()->route('elections.index')
						->with('alert-success','Restored');
	}

    public function getElectionData(Request $request, Election $election)
    {
        $data = [
            'election' => $election
        ];
        return response()->json([
			'election_data' => view('votes.vote', $data)->render()
		]);
    }

    public function updateStatus(Request $request, Election $election)
    {
        $now = Carbon::now();
        $start_date = Carbon::parse($election->start_date);
        $end_date = Carbon::parse($election->end_date);
        if($start_date <= $now && $end_date <= $now){
            $election->update(['status' => 'ongoing']);
        }
        elseif($now > $end_date){
            $election->update(['status' => 'ended']);
        }
    }

    public function results()
    {
        $electionChart = [[]];
        $electionPieChart = [[]];
        $elections = Election::where('status', 'ended')->orderBy('end_date','DESC')->get();
        foreach($elections as $election){
            if(isset($election->id)){
                foreach ($election->candidates->groupBy('position_id') as $position => $candidates) {
                    $electionChart[$election->id][$position] = new OngoingElectionChart;
                    $electionChart[$election->id][$position]->height(300);

                    $electionPieChart[$election->id][$position] = new ElectionResultPieChart;
                    $electionPieChart[$election->id][$position]->height(300);
                    $pieChartLabels = [];
                    $pieChartLabelsByPercentage = [];
                    $votes = [];
                    $pieChartData = [];
                    $labelColors = [];
                    $totalVotes = 0;
                    $electionChart[$election->id][$position]->labels(['votes']);
                    foreach ($candidates as $candidate) {
                        $pieChartLabels[] = $candidate->student->fullname('').($candidate->partylist ? ' ('.$candidate->partylist->name.')' : '');
                        $labelColors[] = ($candidate->partylist->color ?? '#6c757d');
                        $pieChartData[] = $candidate->votes->count();
                        $votes[$candidate->id] = $candidate->votes->count();
                        $totalVotes += $candidate->votes->count();
                    }
                    foreach ($candidates as $candidate) {
                        $legend = $candidate->student->fullname('').($candidate->partylist ? ' ('.$candidate->partylist->name.')' : '');
                        $electionChart[$election->id][$position]->dataset($legend, 'bar', [$votes[$candidate->id]])->backgroundColor(($candidate->partylist->color ?? '#6c757d'))->color(($candidate->partylist->color ?? '#6c757d'));
                    }
                    $electionChart[$election->id][$position]->options([
                        'scales' => [
                            /* 'yAxes' => [[
                                'ticks' => [
                                    'stepSize' => 1,
                                    // 'max' => 5,
                                    // 'max' => 0
                                ]
                            ]], */
                            'xAxes' => [[
                                'gridLines' => [
                                    'display' => true
                                ]
                            ]]
                        ]
                    ]);

                    // Pie Chart
                    foreach ($candidates as $candidate) {
                        $percentage = round(($candidate->votes->count() / $totalVotes) * 100, PHP_ROUND_HALF_UP );
                        $pieChartLabelsByPercentage[] = $candidate->student->fullname('').(isset($candidate->partylist->name) ? ' ('.$candidate->partylist->name.') ' : ' ') . $percentage.'%';
                    }
                    $electionPieChart[$election->id][$position]->labels($pieChartLabelsByPercentage);
                    // $electionPieChart[$election->id][$position]->labels($pieChartLabels);
                    $electionPieChart[$election->id][$position]->dataset('Votes', 'pie', $pieChartData)->backgroundColor($labelColors)->color('#fff');
                    
                    // $electionChart[$election->id][$position]->dataset('votes', 'bar', $votes)->backgroundColor('#007bff')->color('#007bff');
                    $electionPieChart[$election->id][$position]->options([
                        'scales' => [
                            'yAxes' => [[
                                'display' => false,
                                /* 'gridLines' => [
                                    'display' => false
                                ] */
                            ]],
                            'xAxes' => [[
                                'display' => false,
                                /* 'gridLines' => [
                                    'display' => false
                                ] */
                            ]]
                        ]
                    ]);
                }
            }
        }

        $data = [
            'electionChart' => $electionChart,
            'electionPieChart' => $electionPieChart,
            'elections' => $elections,
        ];

        return view('elections.results', $data);
    }

    public function endElection(Election $election)
    {
        $election->update([
            'status' => 'ended'
        ]);

        return redirect()->route('elections.index')->with('alert-success', 'Election Ended');
    }

    public function export() 
    {
        $election = Election::find(request()->get('election_id'));
        $fileName = $election->title.' '.date('Y-m-d-H-i-s').'.xlsx';

        return Excel::download(new ElectionExport(
            $election->id), $fileName
        );
        /* $data = [
            'election' => $election,
            'votes' => Vote::where('election_id', $election->id)->get(),
            'gradeLevels' => Section::get()->groupBy('grade_level'),
        ];
        return view('elections.export', $data); */
    }
}
