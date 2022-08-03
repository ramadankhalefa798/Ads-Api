<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
   
    protected $table = 'advertisements';
    protected $fillable = ['title' , 'description' , 'start_date' , 'type' , 'category_id' , 'user_id'];

   
    public function user(){
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }

    public function category(){
        return $this->belongsTo(Category::class , 'category_id' , 'id');
    }

    public function advertisements_tags()
    {
        return $this->hasMany(AdvertisementsTag::class, 'advertisement_id', 'id');
    }

   

}
