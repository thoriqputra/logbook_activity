<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelActivityType extends Model
{
    protected $table = 'tb_activity_type';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
}
