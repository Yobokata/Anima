<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anime extends Model
{
    protected $table = 'anime';

    public function episodes() {
        return $this->hasMany('App\Episode');
    }
}
