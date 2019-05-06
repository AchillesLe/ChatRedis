<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['name', 'description','owner_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
