<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelActivity extends Model
{
    protected $table = 'tb_activity';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'support_department_id',
        'name',
        'status', 
    ];

    public function support_department()
    {
        return $this->belongsTo('App\Models\ModelSupportDepartment', 'support_department_id');
    }

    public function listActivity()
    {
        return $this->hasOne('App\Models\ModelListActivity', 'id');
    }
}
