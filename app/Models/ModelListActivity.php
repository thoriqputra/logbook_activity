<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelListActivity extends Model
{
    protected $table = 'tb_list_activity';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'start_date',
        'end_date',
        'duration',
        'support_department_id', 
        'activity_id',
        'activity_type_id',
        'user_id',
        'detail_activity',
        'remarks',  
        'requestor_id',
        'channel_requestor_id',
        'url',
        'additional_info'
    ];

    public function support_department()
    {
        return $this->belongsTo('App\Models\ModelSupportDepartment', 'support_department_id');
    }

    public function activity()
    {
        return $this->belongsTo('App\Models\ModelActivity', 'activity_id');
    }

    public function activityType()
    {
        return $this->belongsTo('App\Models\ModelActivityType', 'activity_type_id');
    }

    public function channel_requestor()
    {
        return $this->belongsTo('App\Models\ModelChannelRequestor', 'channel_requestor_id');
    }

    public function requestor()
    {
        return $this->belongsTo('App\Models\ModelRequestor', 'requestor_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
