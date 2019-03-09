<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use GrahamCampbell\Markdown\Facades\Markdown;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    
    use Notifiable;
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','slug','bio','image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts()
    {
       return $this->hasMany('App\Post','author_id');
    }
    
    public function roles(){
        return $this->belongsToMany('App\Role', 'role_user', 'user_id', 'role_id');
    }
    
    public function getRouteKeyName()
    {
        return 'slug';
    }
    
    public function getBioHtmlAttribute($value)
    {
        return $this->bio ?  Markdown::convertToHtml(e($this->bio)) : NULL;
    }
    
}
