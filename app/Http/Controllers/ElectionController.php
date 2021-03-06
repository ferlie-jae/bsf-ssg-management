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
use App\Models\User;
use App\Models\StudentSection;
use App\Models\UserStudent;
use App\Charts\OngoingElectionChart;
use App\Charts\ElectionResultPieChart;
use App\Charts\JuniorHighVotersChart;
use App\Charts\SeniorHighVotersChart;
use App\Charts\VoteChart;
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
        $voteChart = new VoteChart();
        $elections = Election::select('*');
        $juniorHighVoteStatisticsChart = [];
        $seniorHighVoteStatisticsChart = [];
        if(Auth::user()->hasrole('System Administrator')){
            $elections = $elections->withTrashed();
        }
        $activeElection = Election::whereDate('end_date', '>', Carbon::now())->orderBy('end_date','DESC')->first();

        if(isset($activeElection->id)){
            
            // Voters Statistics
            // Junior High School
            $juniorHigh = Section::whereIn('grade_level', ['7', '8', '9', '10'])->get()->groupBy('grade_level');
            foreach($juniorHigh as $grade => $sections){
                $juniorHighVoteStatisticsChart[$grade] = new JuniorHighVotersChart;
                $juniorHighVoteStatisticsChart[$grade]->height('300');

                // $juniorHighSectionIDs = Section::where('grade_level', '=', $grade)->get();
                $juniorHighSectionIDs = [];
                foreach($sections as $section){
                    $juniorHighSectionIDs[] = $section->id;
                }
                // echo  "Grade ".$grade." => ".$juniorHighSectionIDs."</br>";
                $juniorHighIDs = StudentSection::whereIn('section_id', $juniorHighSectionIDs)->get('student_id');
                $juniorHighUserIDs = UserStudent::whereIn('student_id', $juniorHighIDs)->get('user_id');
                $totalVoters = UserStudent::join('users', 'users.id', '=', 'user_students.id')->whereIn('user_students.user_id', $juniorHighUserIDs)->select('users.*')->count();
                $voted = Vote::where('election_id', $activeElection->id)->whereIn('voter_id', $juniorHighUserIDs)->count();
                $notYetVoted = $totalVoters - $voted;
                
                $percentageOfVoted = 0;
                $percentageOfNotYetVoted = 0;
                if($totalVoters > 0){
                    $percentageOfVoted = round(($voted / $totalVoters) * 100, PHP_ROUND_HALF_UP );
                    $percentageOfNotYetVoted = round(($notYetVoted / $totalVoters) * 100, PHP_ROUND_HALF_UP );
                }
                $juniorHighVoteStatisticsChart[$grade]->labels(['Voted ('.$percentageOfVoted.'%)', 'Not voted yet ('.$percentageOfNotYetVoted.'%)']);
                $juniorHighVoteStatisticsChart[$grade]->dataset('Votes', 'pie', [$voted, $notYetVoted])->backgroundColor(['#28a745','#6c757d'])->color('#fff');
                $juniorHighVoteStatisticsChart[$grade]->options([
                    'scales' => [
                        'yAxes' => [[
                            'display' => false,
                        ]],
                        'xAxes' => [[
                            'display' => false,
                        ]]
                    ]
                ]);
            }

            // Senior High School
            $seniorHigh = Section::whereIn('grade_level', ['11', '12'])->get()->groupBy('grade_level');
            foreach($seniorHigh as $grade => $sections){
                foreach($sections as $section){
                    $seniorHighVoteStatisticsChart[$grade.'-'.$section->id] = new SeniorHighVotersChart;
                    $seniorHighVoteStatisticsChart[$grade.'-'.$section->id]->height('300');

                    $seniorHighStudentIDs = [];
                    foreach($section->students as $student){
                        $seniorHighStudentIDs[] = $student->student_id;
                    }
                    $seniorHighUserIDs = UserStudent::whereIn('student_id', $seniorHighStudentIDs)->get('user_id');
                    $totalVoters = UserStudent::join('users', 'users.id', '=', 'user_students.id')->whereIn('user_students.user_id', $seniorHighUserIDs)->select('users.*')->count();
                    $voted = Vote::where('election_id', $activeElection->id)->whereIn('voter_id', $seniorHighUserIDs)->count();
                    $notYetVoted = $totalVoters - $voted;
                    
                    $percentageOfVoted = 0;
                    $percentageOfNotYetVoted = 0;
                    if($totalVoters > 0){
                        $percentageOfVoted = round(($voted / $totalVoters) * 100, PHP_ROUND_HALF_UP );
                        $percentageOfNotYetVoted = round(($notYetVoted / $totalVoters) * 100, PHP_ROUND_HALF_UP );
                    }
                    $seniorHighVoteStatisticsChart[$grade.'-'.$section->id]->labels(['Voted ('.$percentageOfVoted.'%)', 'Not voted yet ('.$percentageOfNotYetVoted.'%)']);
                    $seniorHighVoteStatisticsChart[$grade.'-'.$section->id]->dataset('Votes', 'pie', [$voted, $notYetVoted])->backgroundColor(['#28a745','#6c757d'])->color('#fff');
                    $seniorHighVoteStatisticsChart[$grade.'-'.$section->id]->options([
                        'scales' => [
                            'yAxes' => [[
                                'display' => false,
                            ]],
                            'xAxes' => [[
                                'display' => false,
                            ]]
                        ]
                    ]);
                }
            }
            // End Voters Statistics
        }

        $data = [
            // 'election' => $elections->whereIn('status', ['incoming','ongoing'])->first()
            'election' => $activeElection,
            'juniorHighVoteStatisticsChart' => $juniorHighVoteStatisticsChart,
            'seniorHighVoteStatisticsChart' => $seniorHighVoteStatisticsChart,
            'gradeLevels' => Section::get(),
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
			'title' => ['required'],
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
			'title' => ['required'],
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
        $juniorHighVoteStatisticsChart = [[]];
        $seniorHighVoteStatisticsChart = [[]];
        $now = Carbon::now();
        $elections = Election::where('end_date', '<', $now)->orderBy('end_date','DESC')->get();
        foreach($elections as $election){
            if(isset($election->id)){
                // Voters Statistics
                // Junior High School
                $juniorHigh = Section::whereIn('grade_level', ['7', '8', '9', '10'])->get()->groupBy('grade_level');
                foreach($juniorHigh as $grade => $sections){
                    $juniorHighVoteStatisticsChart[$election->id][$grade] = new JuniorHighVotersChart;
                    $juniorHighVoteStatisticsChart[$election->id][$grade]->height('300');

                    // $juniorHighSectionIDs = Section::where('grade_level', '=', $grade)->get();
                    $juniorHighSectionIDs = [];
                    foreach($sections as $section){
                        $juniorHighSectionIDs[] = $section->id;
                    }
                    // echo  "Grade ".$grade." => ".$juniorHighSectionIDs."</br>";
                    $juniorHighIDs = StudentSection::whereIn('section_id', $juniorHighSectionIDs)->get('student_id');
                    $juniorHighUserIDs = UserStudent::whereIn('student_id', $juniorHighIDs)->get('user_id');
                    $totalVoters = UserStudent::join('users', 'users.id', '=', 'user_students.id')->whereIn('user_students.user_id', $juniorHighUserIDs)->select('users.*')->count();
                    $voted = Vote::where('election_id', $election->id)->whereIn('voter_id', $juniorHighUserIDs)->count();
                    $notYetVoted = $totalVoters - $voted;
                    
                    $percentageOfVoted = 0;
                    $percentageOfNotYetVoted = 0;
                    if($totalVoters > 0){
                        $percentageOfVoted = round(($voted / $totalVoters) * 100, PHP_ROUND_HALF_UP );
                        $percentageOfNotYetVoted = round(($notYetVoted / $totalVoters) * 100, PHP_ROUND_HALF_UP );
                    }
                    $juniorHighVoteStatisticsChart[$election->id][$grade]->labels(['Voted ('.$percentageOfVoted.'%)', 'Did not Vote ('.$percentageOfNotYetVoted.'%)']);
                    $juniorHighVoteStatisticsChart[$election->id][$grade]->dataset('Votes', 'pie', [$voted, $notYetVoted])->backgroundColor(['#28a745','#6c757d'])->color('#fff');
                    $juniorHighVoteStatisticsChart[$election->id][$grade]->options([
                        'scales' => [
                            'yAxes' => [[
                                'display' => false,
                            ]],
                            'xAxes' => [[
                                'display' => false,
                            ]]
                        ]
                    ]);
                }

                // Senior High School
                $seniorHigh = Section::whereIn('grade_level', ['11', '12'])->get()->groupBy('grade_level');
                foreach($seniorHigh as $grade => $sections){
                    foreach($sections as $section){
                        $seniorHighVoteStatisticsChart[$election->id][$grade.'-'.$section->id] = new SeniorHighVotersChart;
                        $seniorHighVoteStatisticsChart[$election->id][$grade.'-'.$section->id]->height('300');

                        $seniorHighStudentIDs = [];
                        foreach($section->students as $student){
                            $seniorHighStudentIDs[] = $student->student_id;
                        }
                        $seniorHighUserIDs = UserStudent::whereIn('student_id', $seniorHighStudentIDs)->get('user_id');
                        $totalVoters = UserStudent::join('users', 'users.id', '=', 'user_students.id')->whereIn('user_students.user_id', $seniorHighUserIDs)->select('users.*')->count();
                        $voted = Vote::where('election_id', $election->id)->whereIn('voter_id', $seniorHighUserIDs)->count();
                        $notYetVoted = $totalVoters - $voted;
                        
                        $percentageOfVoted = 0;
                        $percentageOfNotYetVoted = 0;
                        if($totalVoters > 0){
                            $percentageOfVoted = round(($voted / $totalVoters) * 100, PHP_ROUND_HALF_UP );
                            $percentageOfNotYetVoted = round(($notYetVoted / $totalVoters) * 100, PHP_ROUND_HALF_UP );
                        }
                        $seniorHighVoteStatisticsChart[$election->id][$grade.'-'.$section->id]->labels(['Voted ('.$percentageOfVoted.'%)', 'Did not Vote ('.$percentageOfNotYetVoted.'%)']);
                        $seniorHighVoteStatisticsChart[$election->id][$grade.'-'.$section->id]->dataset('Votes', 'pie', [$voted, $notYetVoted])->backgroundColor(['#28a745','#6c757d'])->color('#fff');
                        $seniorHighVoteStatisticsChart[$election->id][$grade.'-'.$section->id]->options([
                            'scales' => [
                                'yAxes' => [[
                                    'display' => false,
                                ]],
                                'xAxes' => [[
                                    'display' => false,
                                ]]
                            ]
                        ]);
                    }
                }
                // End Voters Statistics

                // Candidates Statistics
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
                        $countVotes = $candidate->votes->count();
                        if($countVotes > 0){
                            $percentage = round(($countVotes / $totalVotes) * 100, PHP_ROUND_HALF_UP );
                        }else{
                            $percentage = 0;
                        }
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
                // End of Candidates Statistics
            }
        }

        $data = [
            'electionChart' => $electionChart,
            'electionPieChart' => $electionPieChart,
            'juniorHighVoteStatisticsChart' => $juniorHighVoteStatisticsChart,
            'seniorHighVoteStatisticsChart' => $seniorHighVoteStatisticsChart,
            'elections' => $elections,
            'gradeLevels' => Section::get(),
        ];

        return view('elections.results', $data);
    }

    public function showVotersStatistics(Request $request, Election $election)
    {
        /* $juniorHighVotersChart = [];
        $seniorHighVotersChart = [[]];

        $juniorHigh = Section::whereIn('setions.grade_level', ['7', '8', '9', '10'])->get()->groupBy('grade_level');
        $juniorHighStudentIDs = [[]];
        foreach ($juniorHigh as $grade => $sections)
        {
            
            if($grade > 10){
                $seniorHighVotersChart[$grade][$election->id] = new JuniorHighVotersChart();
                foreach($sections as $section)
                {

                }
            }else{
                $juniorHighVoters = $section->students;
            }
        }    */
        $voteChart = new VoteChart();
        $voteChart->height('300');
        $totalVoters = UserStudent::join('users', 'users.id', '=', 'user_students.id')->select('users.*')->count();
        $voted = Vote::where('election_id', $election->id)->count();
        $notYetVoted = $totalVoters - $voted;

        // Pie Chart
        $percentageOfVoted = round(($voted / $totalVoters) * 100, PHP_ROUND_HALF_UP );
        $percentageOfNotYetVoted = round(($notYetVoted / $totalVoters) * 100, PHP_ROUND_HALF_UP );
        $voteChart->labels(['Voted ('.$percentageOfVoted.'%)', 'Not yet voted ('.$percentageOfNotYetVoted.'%)']);
        // $electionPieChart[$election->id][$position]->labels($pieChartLabels);
        $voteChart->dataset('Votes', 'pie', [$voted, $notYetVoted])->backgroundColor(['#28a745','#6c757d'])->color('#fff');
        $voteChart->options([
            'scales' => [
                'yAxes' => [[
                    'display' => false,
                ]],
                'xAxes' => [[
                    'display' => false,
                ]]
            ]
        ]);

        $data = [
            'voteStatisticsChart' => $voteChart
        ];

        return response()->json([
            'modal_content' => view('elections.voters_statistics', $data)->render()
        ]);

        // $juniorHighVoters = StudentSection::join('sections', 'sections.id', '=','student_sections.id')->select('student_sections.student_id');
    }

    public function endElection(Election $election)
    {
        $election->update([
            'status' => 'ended',
            'end_date' => Carbon::now(),
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
