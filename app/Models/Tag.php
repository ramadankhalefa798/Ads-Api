<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    // use Translatable;


    protected $table = 'tags';
    protected $fillable = ['name'];

   

    public function advertisements()
    {
        return $this->belongsToMany(Advertisement::class, 'advertisement_id', 'id');
    }

    public function advertisements_tags()
    {
        return $this->hasMany(AdvertisementsTag::class, 'tag_id', 'id');
    }

}
