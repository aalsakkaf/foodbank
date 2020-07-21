<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodCategory extends Model
{
    protected $fillable = ['*'];

    public function foodItems()
    {
        return $this->hasMany('App\foodItem', 'category_id');
    }
}
