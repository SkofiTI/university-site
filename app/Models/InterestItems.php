<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterestItems extends Model
{
    use HasFactory;

    protected $fillable = [
        'interest_id',
        'item'
    ];

    public function interest()
    {
        return $this->belongsTo(Interest::class);
    }
}
