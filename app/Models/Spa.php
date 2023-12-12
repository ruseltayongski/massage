<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spa extends Model
{
    use HasFactory;

    protected $table = 'spa';
    protected $guarded = array();

    public function services()
    {
        return $this->belongsToMany(Services::class);
    }
}
