<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelChannelRequestor extends Model
{
    protected $table = 'tb_channel_requestor';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function listActivity()
    {
        return $this->hasOne('App\Models\ModelListActivity', 'id');
    }
}
