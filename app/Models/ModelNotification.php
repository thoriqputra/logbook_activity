<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelNotification extends Model
{
    protected $table = 'tb_notification';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'notification_data',
        'read_at',
    ];
}
