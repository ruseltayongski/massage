<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    use HasFactory;

    protected $table = 'bookings';
    protected $guarded = array();

    public function ownerWithSpecificTherapist() 
    {
        return $this->belongsTo(User::class, 'therapist_id', 'id');
    }


   /*  public function bookings() 
    {
        return $this->belongsTo(User::class, 'therapist_id', 'id');
    } */
}
