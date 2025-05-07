<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResortImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'resort_id',
        'image_path',
    ];
    // A ResortImage belongs to a Resort
    public function resort()
    {
        return $this->belongsTo(Resort::class, 'resort_id');
    }
    
}
