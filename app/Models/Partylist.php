<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partylist extends Model
{
    use SoftDeletes;
    
    protected $table = 'partylists';

    protected $fillable = [
        'name',
        'color',
    ];
}
