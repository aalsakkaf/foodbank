<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class foodItem extends Model
{
    protected $fillable = ['*'];
    public $table = "foodItems";

    public function donation(){
        return $this->belongsTo('App\Donation', 'donation_id');
    }

    public function FoodCategory()
    {
        return $this->belongsTo('App\FoodCategory', 'category_id');
    }

    public function bundles()
    {
        return $this->belongsToMany('App\Bundle', 'bundle_foodItem', 'foodItem_id', 'bundle_id')->withTimestamps();
    }
}
