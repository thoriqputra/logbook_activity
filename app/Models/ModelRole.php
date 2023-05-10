<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelRole extends Model
{
    protected $table = 'tb_role';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id');
    }
}
