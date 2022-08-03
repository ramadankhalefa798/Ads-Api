<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvertisementsTag extends Model
{
   
    protected $table = 'advertisements_tags';
    protected $fillable = ['advertisement_id' , 'tag_id'];

   
    public function advertisement(){
        return $this->belongsTo(Advertisement::class , 'advertisement_id' , 'id');
    }

    public function tag(){
        return $this->belongsTo(Tag::class , 'tag_id' , 'id');
    }

   

}
