<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeagueStanding extends Model
{
    public $timestamps = false;

    protected $fillable = ['team_id', 'league_id', 'played', 'won', 'drawn', 'lost', 'gf', 'ga', 'gd', 'points'];

    public function team(){
        return $this->belongsTo(Team::class);
    }

    public function assignStats($stats){
        $this->gf = $stats['gf'];
        $this->ga = $stats['ga'];
        $this->gd = $stats['gd'];
        $this->won = $stats['won'];
        $this->lost = $stats['lost'];
        $this->drawn = $stats['drawn'];
        $this->played = $stats['played'];
        $this->points = $stats['points'];
    }
}
