<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;

    protected $table = 'services';
    protected $guarded = array();


    public function spas()
    {
        return $this->belongsToMany(Spa::class, 'service_spa', 'service_spa_id', 'spa_id');
    }
    
    


}
