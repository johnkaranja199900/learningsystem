<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class notes extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'course_id', 'admin_id', 'title', 'content','pdf_file',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function admin()
    {
        return $this->belongsTo(admin::class);
    }
}
