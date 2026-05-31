<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DischargeSummaryItem extends Model
{
    protected $fillable = [
        'discharge_summary_id',
        'product_id',
        'dosage_id',
        'duration',
        'remarks'
    ];

    public function dischargeSummary()
    {
        return $this->belongsTo(DischargeSummary::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function dosage()
    {
        return $this->belongsTo(Dosage::class);
    }
}