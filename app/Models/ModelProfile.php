<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelProfile extends Model
{
    protected $table = 'tb_profile';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'user_id',
        'job', 
        'img_path', 
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
