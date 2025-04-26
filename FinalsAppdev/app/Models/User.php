<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    // Specify the table name
    protected $table = 'registers';  // This tells Laravel to use the 'registers' table

    protected $fillable = [
        'username',
        'email',
        'password',
    ];
}

