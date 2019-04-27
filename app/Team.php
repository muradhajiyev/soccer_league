<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public function leagues(){
        return $this->belongsToMany(League::class);
    }
}
