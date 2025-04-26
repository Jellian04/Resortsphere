<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    protected $table = 'owners';

    protected $fillable = [
        'firstname', 'lastname', 'email', 'username', 'password',
        'zipcode', 'resortname', 'resorts_address', 'type_of_accommodation',
        'resort_img', 'description', 'status',
    ];
}
