<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable,\App\Traits\Uuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public $incrementing=false;
    
    public function roles()
    {
        return $this->belongsToMany('\App\Models\Admin\Role');
    }
    public function isAdmin()
    {
        return $this->roles()->where('name','admin')->first();
    }
}
