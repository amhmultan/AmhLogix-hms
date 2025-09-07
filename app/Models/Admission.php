<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'bed_id',
        'doctor_id',
        'diagnosis',
        'admission_date',
        'discharge_date',
        'status',
        'admission_fees',
    ];

    protected $dates = [
        'admission_date',
        'discharge_date',
    ];

    // Relationships
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function bed()
    {
        return $this->belongsTo(Bed::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function charges()
    {
        return $this->hasMany(Charge::class);
    }

    public function notes()
    {
        return $this->hasMany(DailyNote::class);
    }

    public function dischargeSummary()
    {
        return $this->hasOne(DischargeSummary::class);
    }
}
