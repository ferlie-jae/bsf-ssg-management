<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Election;
use App\Models\Configuration\Position;

class Candidate extends Model
{
    use SoftDeletes;
    
    protected $table = 'candidates';

    protected $fillable = [
        'partylist_id',
        'student_id',
        'election_id',
        'position_id'
    ];

    public function partylist()
    {
        return $this->belongsTo('App\Models\Partylist', 'partylist_id');
    }

    public function student(){
        return $this->belongsTo('App\Models\Student', 'student_id');
    }

    public function election(){
        return $this->belongsTo('App\Models\Election', 'election_id');
    }

    public function position(){
        return $this->belongsTo('App\Models\Configuration\Position', 'position_id');
    }

    public function votes()
    {
        return $this->hasMany('App\Models\VoteData', 'candidate_id');
    }

    public function officers()
    {
        $candidateIDs = [];
        $latestElection = Election::where('status', 'ended')->orderBy('end_date','DESC')->first();
        foreach($election->candidates->groupedBy('position_id') as $position => $candidates)
        {
            $position = Position::find($position);
            $elected = 0;
            $highestVote = 0;
            foreach ($candidates as $candidate) {
                if($highestVote < $candidate->votes->count()){
                    $elected = $candidate->id;
                    $highestVote = $candidate->votes->count();
                }
            }
            $candidateIDs[] = $elected;
        }
    }

    public function isElected()
    {
        $candidates = VoteData::where('position_id', $this->position_id)
        ->groupedBy('candidate_id')
        ->get();
        
    }
    
}
