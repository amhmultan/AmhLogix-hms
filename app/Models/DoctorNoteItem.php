<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Product;
use App\Models\Dosage;
use App\Models\DoctorNote;

class DoctorNoteItem extends Model
{
    protected $fillable = [
        'doctor_note_id',
        'product_id',
        'dosage_id',
        'duration',
        'remarks',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function dosage()
    {
        return $this->belongsTo(Dosage::class);
    }

    public function doctorNote()
    {
        return $this->belongsTo(DoctorNotes::class);
    }
}