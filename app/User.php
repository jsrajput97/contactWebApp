<?php

namespace App;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements  Authenticatable
{
    //protected $table = 'tablename';
    use \Illuminate\Auth\Authenticatable;
    public function contacts()
    {
        return $this->hasMany('App\Contact');

    }
    public function verifyUser()
    {
        return $this->hasOne('App\VerifyUser');
    }
    public function passReset()
    {
        return $this->hasOne('App\PassReset');
    }

}
