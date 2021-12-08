<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use Illuminate\Http\Request;
use App\Models\Election;
use App\Models\Configuration\Position;
use App\Models\Candidate;
use App\Models\VoteData;
use App\Models\UserStudent;
use App\Models\Student;
use Auth;

class VoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vote = Vote::select('*');

        if(Auth::user()->hasrole('System Administrator'))
        {
            $vote = $vote->withTrashed();
        }
        
        if(Auth::user()->hasrole('Student')){
            $vote = $vote->where('voter_id', Auth::user()->id);
        }

        $data = [
            'votes' => $vote->get(),
            'elections' => Election::get(),
        ];

        return view('votes.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(request()->ajax()){
            $studentVotes = Vote::where([
                'voter_id' => Auth::user()->id
            ])->select('election_id');

            $data = ([
                'elections' => Election::whereNotIn('id', $studentVotes)->where('status', 'ongoing')->get()
            ]);

            return response()->json([
                'modal_content' => view('votes.create', $data)->render()
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
            'election_id' => 'required'
        ]);

        $vote = Vote::create([
            'vote_number' => time(),
            'election_id' => $request->get('election_id'),
            'voter_id' => Auth::user()->id,
        ]);

        foreach ($request->get('position') as $position => $candidate) {
            if(is_array($candidate)){
                foreach($candidate as $selected) {
                    VoteData::create([
                        'vote_id' => $vote->id,
                        'position_id' => $position,
                        'candidate_id' => $selected,
                    ]);
                }
            }else{
                VoteData::create([
                    'vote_id' => $vote->id,
                    'position_id' => $position,
                    'candidate_id' => $candidate,
                ]);
            }
        }
        
        return redirect()->route('votes.index')->with('alert-success', 'Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function show(Vote $vote)
    {
        if(request()->json()){
            $data = [
                'vote' => $vote
            ];
            return response()->json([
                'modal_content' => view('votes.show', $data)->render()
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function edit(Vote $vote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vote $vote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vote $vote)
	{
		if (request()->get('permanent')) {
            foreach($vote->vote_data as $vote_data)
            {
                $vote_data->forceDelete();
            }
			$vote->forceDelete();
		}else{
            foreach($vote->vote_data as $vote_data)
            {
                $vote_data->delete();
            }
			$vote->delete();
        }
		return redirect()->route('votes.index')
						->with('alert-danger','Deleted');
	}

	public function restore($vote)
	{
		$vote = Vote::withTrashed()->find($vote);
		$vote->restore();
		foreach($vote->vote_data as $vote_data)
        {
            $vote_data->restore();
        }
		return redirect()->route('votes.index')
						->with('alert-success','Restored');
	}

    /**
     * For Development Only!
     */
    public function randomVotes(Request $request)
    {
        $userStudents = UserStudent::get();
        $election = Election::find($request->get('election'));
        $candidatesByPosition = $election->candidates->groupBy('position_id');

        foreach($userStudents as $voter)
        {
            $vote = Vote::create([
                'vote_number' => $this->randomVoteNumber(),
                'election_id' => $request->get('election'),
                'voter_id' => $voter->user_id,
            ]);

            foreach ($candidatesByPosition as $positionID => $candidates)
            {
                // echo $position->position->name;
                $position = Position::find($positionID);
                for ($i=0; $i < $position->candidate_to_elect; $i++) {
                    VoteData::create([
                        'vote_id' => $vote->id,
                        'position_id' => $position->id,
                        'candidate_id' => $this->randomCandidate($vote, $position->id, $i),
                    ]);
                }
            }
        }

        return redirect()->route('votes.index')->with('alert-success', 'Saved');

    }

    public function randomCandidate($vote, $positionID, $index)
    {
        $candidate = Candidate::where([
            ['election_id', $vote->election_id], 
            ['position_id', $positionID], 
        ])->inRandomOrder()->first();
        if($index > 0){
            $voteData = VoteData::where([
                ['vote_id', $vote->id],
                ['position_id', $candidate->position_id],
                ['candidate_id', $candidate->id],
            ])->exists();
            if($voteData){
                return $this->randomCandidate($vote, $positionID, $index);
            }
        }
        return $candidate->id;
        
    }

    public function randomVoteNumber()
	{
		$number = mt_rand(100000000, 999999999); // better than rand()


		if ($this->voteNumberExists($number)) {
			return uniqueID();
		}

		// otherwise, it's valid and can be used
		return $number;
	}

    public function voteNumberExists($number)
	{
		return Vote::where('vote_number', $number)->exists();
	}
    
}
