<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorNotes extends Model
{
    use HasFactory;

    protected $fillable = [
    'fk_patient_id',
    'fk_token_id',
    'prescription',
    'mode',
    'c_o',
    'o_e',
    'va',
    'at',
    'lids',
    'conjunctiva',
    'cornea',
    'ac',
    'lens',
    'fundus',
    'prescription_text',
    'dm',
    'htn',
    'ihd',
    'asthma',
];


  public function patient()
  {
    return $this->belongsTo(Patient::class, 'fk_patient_id');
  }

  public function token()
  {
    return $this->belongsTo(Token::class, 'fk_token_id');
  }
    
  public function doctorName()
  {
    return $this->token?->doctor?->name
      ?? $this->doctor_name
      ?? 'Walk-in / Manual';
  }
}
