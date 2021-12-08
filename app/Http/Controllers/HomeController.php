<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Election;
use App\Models\Student;
use App\Models\Faculty;
use App\Models\Task;
use App\Models\Votes;
use App\Models\User;
use App\Models\Configuration\Position;
use App\Charts\OngoingElectionChart;
use App\Charts\ElectionResultPieChart;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $students = Student::get()->count();
        $faculties = Faculty::get()->count();
        $taskDone = Task::where('is_done', 1)->get()->count();
        $tasks = Task::get()->count();
        $users = User::get()->count();

        $electionChart = [];
        $electionPieChart = [];
        $ongoingElection = Election::where('status', 'ongoing')->orderBy('start_date','DESC')->first();
        if(isset($ongoingElection->id)){
            foreach ($ongoingElection->candidates->groupBy('position_id') as $position => $candidates) {
                $electionChart[$position] = new OngoingElectionChart;
                $electionChart[$position]->height(300);

                $electionPieChart[$position] = new ElectionResultPieChart;
                $electionPieChart[$position]->height(300);
                $pieChartLabels = [];
                $pieChartLabelsByPercentage = [];
                $votes = [];
                $pieChartData = [];
                $labelColors = [];
                $totalVotes = 0;
                $electionChart[$position]->labels(['votes']);
                foreach ($candidates as $candidate) {
                    $pieChartLabels[] = $candidate->student->fullname('').(isset($candidate->partylist->name) ? ' ('.$candidate->partylist->name.')' : '');
                    $labelColors[] =  $candidate->partylist->color ?? '#6c757d';
                    $pieChartData[] = $candidate->votes->count();
                    $votes[$candidate->id] = $candidate->votes->count();
                    $totalVotes += $candidate->votes->count();
                }
                foreach ($candidates as $candidate) {
                    $legend = $candidate->student->fullname('').(isset($candidate->partylist->name) ? ' ('.$candidate->partylist->name.')' : '');
                    $electionChart[$position]->dataset($legend, 'bar', [$votes[$candidate->id]])->backgroundColor(($candidate->partylist->color ?? '#6c757d'))->color(($candidate->partylist->color ?? '#6c757d'));
                }
                $electionChart[$position]->options([
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
                $electionPieChart[$position]->labels($pieChartLabelsByPercentage);
                // $electionPieChart[$position]->labels($pieChartLabels);
                $electionPieChart[$position]->dataset('Votes', 'pie', $pieChartData)->backgroundColor($labelColors)->color('#fff');
                
                // $electionChart[$position]->dataset('votes', 'bar', $votes)->backgroundColor('#007bff')->color('#007bff');
                $electionPieChart[$position]->options([
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

        $data = [
            'electionPieChart' => $electionPieChart,
            'electionChart' => $electionChart,
            'election' => $ongoingElection,
            'taskDone' => $taskDone,
            'tasks' => $tasks,
            'faculties' => $faculties,
            'students' => $students,
            'users' => $users,
        ];

        return view('dashboard', $data);
    }
}
