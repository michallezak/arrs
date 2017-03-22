<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;

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
     * Detach all permission from a role
     *
     * @return object
     */
    public function detachAllRole()
    {
        DB::table('role_user')->where('user_id', $this->id)->delete();

        return $this;
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function allRole($id){
        $role_user = DB::table('role_user')->select('role_id')->where('user_id','=',$id)->get()->toArray();
        return $role_user;
    }
}
