<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Diary extends Model
{
    protected $fillable = ['entry'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function setEntryAttribute($value)
    {
        $this->attributes['entry'] = Crypt::encryptString($value);
    }

    public function getEntryAttribute($value)
    {
        return Crypt::decryptString($value);
    }
}
