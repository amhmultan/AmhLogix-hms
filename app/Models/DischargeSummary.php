<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DischargeSummary extends Model
{
    use HasFactory;

    protected $fillable = [
        'admission_id',
        'clinical_notes',
        'medications',
        'follow_up',
        'dm',
        'htn',
        'ihd',
        'asthma',
    ];

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }
}
