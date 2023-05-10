<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelSupportDepartment extends Model
{
    protected $table = 'tb_support_department';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function activity()
    {
        return $this->hasMany('App\Models\ModelActivity', 'support_department_id');
    }

    public function listActivity()
    {
        return $this->hasOne('App\Models\ModelListActivity', 'id');
    }
}
