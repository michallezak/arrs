<?php

namespace App;

use Zizaco\Entrust\EntrustRole;
use Illuminate\Support\Facades\DB;

class Role extends EntrustRole
{
    /**
     * Detach all permission from a role
     *
     * @return object
     */
    public function detachAllPermission()
    {
        DB::table('permission_role')->where('role_id', $this->id)->delete();

        return $this;
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function allPermission($id){
        $permission_role = DB::table('permission_role')->select('permission_id')->where('role_id','=',$id)->get()->toArray();
        return $permission_role;
    }
}