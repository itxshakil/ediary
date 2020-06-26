<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Profile extends Model
{
    protected $fillable = ['name','bio','image'];
    
    public function user()
    {
        return $this->belongsTo(User::class)->select(['id','username'])->withCount('following');
    }

    public function getImageAttribute($value)
    {
        if ($value) {
            return Storage::disk('s3')->url($value);
        }

        return "https://source.unsplash.com/96x96/daily";
    }
    
    public function follower()
    {
        return $this->belongsToMany(User::class);
    }
}
