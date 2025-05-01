<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingOwner extends Model
{
    protected $table = 'pending_owners'; // tell Laravel the exact table
    public $timestamps = false; // set to true if your table has created_at/updated_at

    // Add this
    protected $fillable = [
        'firstname', 'lastname', 'email', 'username', 'password',
        'zipcode', 'resortname', 'resorts_address', 'type_of_accommodation',
        'description', 'resort_img', 'status', 'user_id'
    ];
}
