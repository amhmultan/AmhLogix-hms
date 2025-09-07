<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    protected $fillable = [
        'fk_patients_id',
        'fk_doctors_id',
        'fk_specialty_id',
        'fees',
        'denomination',
        'balance'
    ];

    public function patient() {
    return $this->belongsTo(Patient::class, 'fk_patients_id');
    }
    public function doctor() {
        return $this->belongsTo(Doctor::class, 'fk_doctors_id');
    }
    public function speciality() {
        return $this->belongsTo(Speciality::class, 'fk_specialty_id');
    }
    public function doctor_notes()
    {
        return $this->hasMany(DoctorNotes::class);
    }
}
