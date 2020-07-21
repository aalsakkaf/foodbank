<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
    protected $fillable = ['*'];

    public function foodItems()
    {
        return $this->belongsToMany('App\foodItem', 'bundle_foodItem', 'bundle_id', 'foodItem_id')->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
