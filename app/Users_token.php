<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users_token extends Model
{
    protected $table = 'users_tokens';
    protected $fillable = [
        'id_user', 'token', 'expired_at'
    ];
}
