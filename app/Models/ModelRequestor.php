<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelRequestor extends Model
{
    protected $table = 'tb_requestor';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'name',
        'username',
    ];

    
    public function listActivity()
    {
        return $this->hasOne('App\Models\ModelListActivity', 'id');
    }
}
