<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModelNotification;
use App\Models\ModelProfile;
use Carbon\Carbon;

class NotificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notification   = ModelNotification::orderBy('created_at', 'DESC')->get();
        
        $data   = [];
        $data['count']  = ModelNotification::whereNull('read_at')->get()->count();
        $data['total']  = count($notification);
        
        if(count($notification) > 0){
            foreach($notification as $rows){
                $decode_notification_data   = json_decode($rows->notification_data, true);

                $profile    = ModelProfile::where('user_id', $decode_notification_data['user_id'])->first();

                $data['data'][] = [
                    'id'                    => $rows->id,
                    'notification_data'     => str_replace('[$name]', $profile->name, $rows->notification_data),
                    'notification_image'    => $profile->img_path,
                    'read_at'               => $rows->read_at !== null ? Carbon::parse($rows->read_at)->diffForHumans() : null,
                    'created_at'            => $rows->created_at->diffForHumans(),
                ];
            }
        }else{
            $data['data'][] = [
                'id'                => null,
                'notification_data' => null,
                'read_at'           => null,
                'created_at'        => null,
            ];
        }
        
        return $data;
    }

    public function mark_all_as_read()
    {
        ModelNotification::whereNull('read_at')->update([
            'read_at'   => Carbon::now()
        ]);

        $notification   = ModelNotification::orderBy('created_at', 'DESC')->get();
        
        $data   = [];
        $data['count']  = ModelNotification::whereNull('read_at')->get()->count();
        $data['total']  = count($notification);
        foreach($notification as $rows){
            $decode_notification_data   = json_decode($rows->notification_data, true);

            $profile    = ModelProfile::where('user_id', $decode_notification_data['user_id'])->first();

            $data['data'][] = [
                'id'                => $rows->id,
                'notification_data' => str_replace('[$name]', $profile->name, $rows->notification_data),
                'notification_image'    => $profile->img_path,
                'read_at'           => Carbon::parse($rows->read_at)->diffForHumans(),
            ];
        }

        return $data;
    }
}
