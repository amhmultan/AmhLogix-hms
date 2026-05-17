<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'fk_user_id','name','fname','dob','gender','marital_status','phone','email','cnic','address','emr_name','relationship','emr_phone','history','reffered_by'
    ];

    public function getAgeDetailedAttribute()
    {
    if (!$this->dob) {
        return null;
        }

        $dob = Carbon::parse($this->dob);
        $now = Carbon::now();

        $years = $dob->diffInYears($now);
        $months = $dob->copy()->addYears($years)->diffInMonths($now);
        $days = $dob->copy()->addYears($years)->addMonths($months)->diffInDays($now);

        // return $years . ' Y ' . $months . ' M ' . $days . ' D ';
        return $years . ' Years ' ;
    }

    public function users()
    {
      return $this->belongsTo(User::class, 'fk_user_id');
    }

    public function token()
   {
        return $this->hasMany(Token::class);
   }

   public function doctor_notes()
   { 
       return $this->hasMany(DoctorNotes::class);
   }

   public function sales()
   {
       return $this->hasMany(SaleInvoice::class);
   }
}
