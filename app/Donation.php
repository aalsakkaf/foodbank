<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = ['*'];
    
    public function foodItems()
    {
        return $this->hasMany('App\foodItem');
    }

    public function location()
    {
        return $this->belongsTo('App\Location');
    }
    public function status()
    {
        return $this->belongsTo('App\Status');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
    public function rewardPoint(){
        return $this->belongsTo('App\rewardPoint', 'rewardPoint_id');
    }

    public function delivery()
    {
        return $this->hasOne('App\Delivery');
    }
}
