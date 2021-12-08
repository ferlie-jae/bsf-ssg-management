<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\VoteData;

class Vote extends Model
{
	use SoftDeletes;
    
    protected $table = 'votes';

    protected $fillable = [
        'vote_number',
        'election_id',
        'voter_id',
    ];

    public function user(){
        return $this->belongsTo('App\Models\User', 'voter_id');
    }

    public function election(){
        return $this->belongsTo('App\Models\Election', 'election_id');
    }

    public function vote_data()
    {
        return $this->hasMany('App\Models\VoteData', 'vote_id');
    }

    public function isVotedCandidate($candidateID)
    {
        if(VoteData::where([
            ['vote_id', $this->id],
            ['candidate_id', $candidateID],
        ])->exists()){
            return True;
        }
        return False;
    }
}
