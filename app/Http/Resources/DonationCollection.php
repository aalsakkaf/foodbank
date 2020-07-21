<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\Resource;

class DonationCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //dd( $request);
        //return $this->map(function($donation) {
        return [
            'title' => $this->title,
            'details' => $this->details,
            'availableDate' => $this->availableDate,
            'user' => $this->user->name,
            'status'=>$this->status->name,
            
        ];
        //});
    }
}
