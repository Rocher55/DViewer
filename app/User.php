<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends \TCG\Voyager\Models\User
{
    use Notifiable;

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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*public function roles(){
        return $this->belongsToMany('App\Role','user_roles');
    }

    public function role(){
        return $this->belongsTo('App\Role');
    }
    */

    public function isAdminOrAdmiral(){
        return ($this->roles()->whereIn('name', ['admin','Amiral'])->exists()
            or $this->role()->whereIn('name', ['admin','Amiral'])->exists());
    }
}
