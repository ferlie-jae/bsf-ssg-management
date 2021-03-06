<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Models\Candidate;
use App\Models\Configuration\Position;
use Auth;

class Election extends Model
{
    use SoftDeletes;
    
    protected $table = 'elections';

    protected $dates = [
        'start_date',
        'end_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'status',
        'title',
        'description',
        'start_date',
        'end_date'
    ];

    public function candidates() {
        /* if(Auth::user()->hasrole('System Administrator')){
            return $this->hasMany('App\Models\Candidate', 'election_id')->withTrashed();
        } */
        return $this->hasMany('App\Models\Candidate', 'election_id');
    }

    public function votes() {
        return $this->hasMany('App\Models\Vote', 'election_id');
    }

    public function findCandidate($candidateID, $positionID)
    {
        $query = Candidate::where([
            ['election_id', $this->id],
            ['student_id', $candidateID],
            ['position_id', $positionID],
        ])->exists();
        if($query){
            return True;
        }else{
            return False;
        }
    }

    public function getStatus()
    {
        $now = Carbon::now();
        $start_date = Carbon::parse($this->start_date);
        $end_date = Carbon::parse($this->end_date);
        $status = 'incoming';

        if($start_date->lt($now) && $end_date->gt($now)){
            $status = 'ongoing';
        }
        elseif($end_date->lt($now)){
            $status = 'ended';
        }
        return $status;
    }

    public function getStatusBadge()
    {
        $status = $this->getStatus();
        $badge = "";
        switch ($status) {
            case 'incoming':
                $badge = '<span class="badge badge-warning">Incoming</span>';
                break;
            case 'ongoing':
                $badge = '<span class="badge badge-success">Ongoing</span>';
                break;
            case 'ended':
                $badge = '<span class="badge badge-primary">Ended</span>';
                break;
            
            default:
                # code...
                break;
        }
        return $badge;
    }

    public function getElectedCandidateByPosition($positionID)
    {
        $position = Position::find($positionID);
        if(isset($this->id)){
            if($position->candidate_to_elect > 1) {
                $candidates = Candidate::where([
                    ['election_id', $this->id],
                    ['position_id', $position->id],
                ]);
                $highestVote = 0;
                $finalElected = [];
                for ($i=0; $i < $position->candidate_to_elect; $i++) 
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
            else {
                $candidates = Candidate::where([
                    ['election_id', $this->id],
                    ['position_id', $position->id],
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

    /* public function status() {
        $status = "";
        $startDate = Carbon::parse($this->start_date);
        $endDate = Carbon::parse($this->end_date);
        $endDate = Carbon::parse(time());
        if($this->status == '1') {
            $status = "Active";
        }
        elseif($startDate) {
            $status = "Finished";
        }
        elseif($this->start_date == ) {
            $status = "Finished";
        }
        else {
            $status = "";
        }
        return $status;
    } */
}
