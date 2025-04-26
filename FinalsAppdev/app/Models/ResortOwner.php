<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // this makes the model compatible with Auth
use Illuminate\Notifications\Notifiable;

class ResortOwner extends Authenticatable
{
    use Notifiable;

    protected $table = 'registers'; // connects model to your actual table

    protected $fillable = ['username', 'password'];

    public $timestamps = false;
}
