<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    
    // protected $fillable = [
    //     'roles',
    //     'fname',
    //     'lname',
    //     'address',
    //     'mobile',
    //     'picture',
    //     'email',
    //     'email_verified_at',
    //     'password',
    //     'ftl',
    //     'is_deleted',
    //     'created_at',
    //     'updated_at'
    // ];

    protected $guarded = array();

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function spas()
    {
        return $this->hasMany(Spa::class, 'owner_id');
    }

    public function therapist() 
    {
        return $this->hasMany(User::class, 'owner_id')->where('roles', 'THERAPIST');
    }

    public function services() 
    {
        return $this->hasMany(Services::class, 'owner_id');
    }

}
