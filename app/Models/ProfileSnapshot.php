<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileSnapshot extends Model
{
    protected $fillable = [
        'profile_id',
        'name',
        'bio',
        'likes_count',
        'raw_data',
    ];

    protected $casts = [
        'raw_data' => 'array',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
