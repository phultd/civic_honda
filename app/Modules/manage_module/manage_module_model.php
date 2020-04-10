<?php

namespace App\Modules\manage_module;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class manage_module_model extends Model
{
    use SoftDeletes;
    protected $table = "cms_module";

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
