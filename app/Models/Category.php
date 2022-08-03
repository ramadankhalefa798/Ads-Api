<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
   
    protected $table = 'categories';
    protected $fillable = ['name' , 'description'];

   


    public function advertisements()
    {
        return $this->hasMany(Advertisement::class, 'category_id', 'id');
    }

   

}
