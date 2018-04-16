<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    protected $table = 'episodes';

    public function anime() {
        return $this->belongsTo('App\Anime');
    }
}
