<?php

namespace App\Modules\manage_role;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class manage_role_model extends Model
{
    protected $table = "cms_role";

	/**
     * Get users has this role.
     */
    public function get_users()
    {
        return $this->hasMany('App\Modules\manage_user\User', 'role_id', 'id');
    }

}
