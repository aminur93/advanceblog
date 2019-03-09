<?php

namespace App;

use Laratrust\LaratrustRole;

class Role extends LaratrustRole
{
    public function users(){
        return $this->belongsToMany('App\User','role_user', 'role_id', 'user_id');
    }
}
