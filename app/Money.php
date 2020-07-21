<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Money extends Model
{
    protected $fillable = ['*'];
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function rewardPoint(){
        return $this->belongsTo('App\rewardPoint', 'rewardPoint_id');
    }
}
