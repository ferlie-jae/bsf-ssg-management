<?php

namespace App\Models\Configuration;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Election;
use App\Models\Student;
use App\Models\Candidate;

class Position extends Model
{
	use SoftDeletes;
    
    protected $table = 'positions';

    protected $fillable = [
        'name',
        'candidate_to_elect',
    ];

    public function electedOfficer()
    {
        $latestElection = Election::where('status', 'ended')->orderBy('end_date','DESC')->first();
        if(isset($latestElection->id)){
            if($this->candidate_to_elect > 1)
            {
                $candidates = Candidate::where([
                    ['election_id', $latestElection->id],
                    ['position_id', $this->id],
                ]);
                $highestVote = 0;
                $finalElected = [];
                for ($i=0; $i < $this->candidate_to_elect; $i++) 
                {
                    $highestVote = 0;
                    $electedID = 0;
                    foreach($candidates->whereNotIn('id', $finalElected)->get() as $candidate)
                    {
                        if($candidate->votes->count() > $highestVote) {
                            $highestVote= $candidate->votes->count();
                            $electedID = $candidate->id;
                        }
                    }
                    $finalElected[] = $electedID;
                }
                return Candidate::whereIn('id', $finalElected)->get();
            }
            else
            {
                $candidates = Candidate::where([
                    ['election_id', $latestElection->id],
                    ['position_id', $this->id],
                ])->get();
                $highestVote = 0;
                $electedID = 0;
                foreach($candidates as $candidate)
                {
                    if($candidate->votes->count() > $highestVote) {
                        $electedID = $candidate->id;
                        $highestVote = $candidate->votes->count();
                    }
                }
                return Candidate::find($electedID);
            }
        }else{
            return false;
        }

    }

}
