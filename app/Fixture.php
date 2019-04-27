<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fixture extends Model
{

    public function homeTeam(){
        return $this->belongsTo(Team::class, 'team_home_id');
    }

    public function awayTeam(){
        return $this->belongsTo(Team::class, 'team_away_id');
    }


    public function league(){
        return $this->belongsTo(League::class);
    }


    public function scopePlayed($query)
    {
        return $query->whereNotNull('goals_team_home')->whereNotNull('goals_team_away');
    }

    public function scopeNotPlayed($query)
    {
        return $query->whereNull('goals_team_home')->whereNull('goals_team_away');
    }

}
