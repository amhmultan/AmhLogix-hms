<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'admission_id',
        'user_id',
        'notes',
        'vitals',
    ];

    protected $casts = [
        'vitals' => 'array', // auto-cast JSON into array
    ];

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
