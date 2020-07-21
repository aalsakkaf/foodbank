<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['*'];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
