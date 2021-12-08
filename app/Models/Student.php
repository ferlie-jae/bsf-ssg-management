<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Configuration\Position;
use App\Models\Election;
use App\Models\Candidate;
use App\Models\Vote;
use App\Models\VoteData;

class Student extends Model
{
	use SoftDeletes;
    
    protected $table = 'students';

    protected $fillable = [
        'student_id',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'birth_date',
        'contact_number',
        'address'
    ];

    public function section() {
        return $this->hasOne('App\Models\StudentSection', 'student_id');
    }

    public function user() {
        return $this->hasOne('App\Models\UserStudent', 'student_id');
    }

    public function tasks()
    {
        return $this>hasMany('App\Models\Task', 'student_id');
    }

    public function getStudentName()
	{
		$student = self::find($this->id);
        $name = $student->first_name.' '.
            (is_null($student->middle_name) ? '' : $student->middle_name[0].'. ').
            $student->last_name;
		return $name;
    }
    public function getStudentNameLNF()
	{
		$student = self::find($this->id);
        $name = $student->last_name.', '.
        $student->first_name.' '.
        (is_null($student->middle_name) ? '' : $student->middle_name[0].'.');
		return $name;
    }

    /** 
     * $format = 'f-m-l'
     * $format = 'l-f-m'
     * $format = 'l-f-M'
     */
    public function fullname($format)
	{
        $format = explode('-', $format);
        $name = "";
        for ($i=0; $i < count($format); $i++) { 
            switch ($format[$i]) {
                case 'f':
                    if($i == 0)
                        $name .= $this->first_name;
                    elseif($i == 1)
                        $name .= $this->first_name;
                    break;
                case 'm':
                    if(!is_null($this->middle_name) && $this->middle_name!=''){
                        if($i == 1){
                            $name .= ' '.$this->middle_name[0].'. ';
                        }else{
                            $name .= ' '.$this->middle_name[0].'. ';
                        }
                    }
                    break;
                case 'M':
                    if($i == 1){
                        $name .= ' '.$this->middle_name.' ';
                    }elseif($i == 2){
                        $name .= ' '.$this->middle_name;
                    }
                    break;
                case 'l':
                    if($i == 0){
                        $name .= $this->last_name.', ';
                    }elseif($i == 2){
                        $name .= ' '.$this->last_name;
                    }
                    break;
                
                default:
                $name = $this->first_name.' '.
                    ((is_null($this->middle_name) && $this->middle_name!='') ? '' : $this->middle_name[0].'. ').
                    $this->last_name;
                    break;
            }
        }
		
		return $name;
    }
    
    public function isOfficer()
    {
        $latestElection = Election::where('status', 'ended')->orderBy('end_date','DESC')->first();
        if(isset($latestElection->id)){
            foreach (self::officers() as $officer) {
                if($this->id == $officer->student_id){
                    return True;
                }
            }
        }
        return False;
        
    }

    public function getPosition()
    {
        $latestElection = Election::where('status', 'ended')->orderBy('end_date','DESC')->first();
        if(isset($latestElection->id)){
            $candidate = Candidate::where([
                ['election_id', $latestElection->id],
                ['student_id', $this->id],
            ]);
    
            if($candidate->exists()){
                $candidate = $candidate->first();
                return $candidate->position->name;
            }
        }
        return "N/A";
        
    }

    /**
     * get elected officers from candidates table
     */
    public static function officers()
    {
        $latestElection = Election::where('status', 'ended')->orderBy('end_date','DESC')->first();
        $candidatesID = [];
        if(isset($latestElection->id)){
            foreach(Position::get() as $position)
            {
                if($position->candidate_to_elect > 1)
                {
                    $candidates = Candidate::where([
                        ['election_id', $latestElection->id],
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
                        $candidatesID[] = $electedID;
                    }
                }
                else
                {
                    $candidates = Candidate::where([
                        ['election_id', $latestElection->id],
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
                    $candidatesID[] = $electedID;
                }
            }
        }
        return Candidate::whereIn('id', $candidatesID)->get();
    }

    public function getVotedCandidate($electionID, $position){
        $vote = Vote::where([
            ['election_id', $electionID],
            ['voter_id', $this->user->user_id],
        ])->first();
        if($position->candidate_to_elect < 2){
            return VoteData::where([
                ['vote_id', $vote->id],
                ['position_id', $position->id],
            ])->first();
        }else{
            return VoteData::where([
                ['vote_id', $vote->id],
                ['position_id', $position->id],
            ])->get();
        }
    }
}
