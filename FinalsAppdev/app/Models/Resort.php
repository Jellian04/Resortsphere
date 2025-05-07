<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resort extends Model
{
    use HasFactory;

    protected $fillable = [
        'registers_id',
        'resort_name',
        'resort_address',
        'accommodation_type',
        'status',
        'description', // Add description here

    ];

    // A resort belongs to a register (user)
    public function register()
    {
        return $this->belongsTo(Register::class, 'registers_id');
    }

     // A Resort has many ResortImages
     public function resortImages()
     {
         return $this->hasMany(ResortImage::class, 'resort_id');
     }
}
