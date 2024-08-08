<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'amount',
        'phone',
        'account_reference',
        'transaction_desc',
        'status',
        'user_id',
    ];
     public function user()
    {
        return $this->belongsTo(users::class);
    }
}
