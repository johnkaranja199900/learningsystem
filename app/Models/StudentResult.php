<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentResult extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'introduction',
        'windows',
        'word',
        'excel',
        'access',
        'powerpoint',
        'publisher',
        'pagemaker',
        'DOS',
        'internet',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
