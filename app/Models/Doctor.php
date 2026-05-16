<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'pic', 'name', 'contact', 'email', 'address', 'dob',
        'speciality_id', 'schedule', 'remarks', 'cnic', 'pmdc'
    ];

    public function specialty()
    {
        return $this->belongsTo(Speciality::class, 'speciality_id');
    }

    public function token()
    {
        return $this->hasMany(Token::class);
    }
}
