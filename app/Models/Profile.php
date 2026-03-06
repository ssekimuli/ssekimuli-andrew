<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

class Profile extends Model
{
    use HasFactory, Searchable;

    public function searchableAs()
    {
        return 'profiles_index';
    }
    public function indexableAs()
    {
        return $this->searchableAs();
    }

    public function toSearchableArray(): array {
        return [
            'username' => $this->username,
            'name' => $this->name,
            'bio' => $this->bio,
        ];
    }

    public function snapshots()
    {
        return $this->hasMany(ProfileSnapshot::class);
    }
}
