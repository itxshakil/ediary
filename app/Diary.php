<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Crypt;

class Diary extends Model
{
    use HasFactory;

    protected $fillable = ['entry'];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function setEntryAttribute($value)
    {
        $this->attributes['entry'] = Crypt::encryptString($value);
    }

    public function getEntryAttribute($value): string
    {
        return Crypt::decryptString($value);
    }
}
