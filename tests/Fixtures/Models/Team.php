<?php

namespace TempiMarathon\FilamentLocalAvatars\Tests\Fixtures\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    /** @var list<string> */
    protected $fillable = [
        'name',
    ];
}
