<?php

namespace App\Modules\Home\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Response;
use App\Models\ModelProfile;
use App\Models\ModelNotification;
use App\Models\ModelListActivity;
use App\Models\User;
use App\Models\ModelRole;
use Carbon\Carbon;

class HomeController extends Controller
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
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public $controller_name = 'Home';

    public function index(){
        $title  = "Home";
        
        $user_id    = Auth::user()->id;
        $profile    = ModelProfile::where('user_id', $user_id)->first();
        
        $arrListActivity    = [];
        if(\Auth::user()->role_id !== 1){
            $list_activity    = ModelListActivity::with('department', 'activity')->where('user_id', \Auth::user()->id)->get();

            foreach($list_activity as $rows){
                if($rows->department->name === "IT SIM"){
                    $color = '#737CA1';
                }elseif($rows->department->name = "IT SPM"){
                    $color  = '#123456';
                }elseif($rows->department->name = "IT SMC"){
                    $color  = '#56A5EC';
                }elseif($rows->department->name = "SSOE"){
                    $color  = '#48D1CC';
                }elseif($rows->department->name = "Resource Pooling"){
                    $color  = '#307D7E';
                }else{
                    $color  = '#ADD8E6';
                }

                $arrListActivity[] = [
                    "id"    => $rows->id,
                    "title" => $rows->id.' - '.$rows->department->name,
                    "start" => $rows->start_date,
                    "end"   => $rows->end_date,
                    "color" => $color,
                    "description"   => $rows->activity->name,
                ];
            }
        }

        $data   = [
            'title'             => $title,
            'profile'           => $profile,
            'list_activity'     => $arrListActivity,
        ];

        return view($this->controller_name . '::index')->with($data);
    }

    public function get_user_list(){
        $userList   = User::with('role')->orderBy('created_at', 'desc')->get();
        
        $data   = [];
        $no     = 1;

        foreach ($userList as $key => $value) {
            $data[]   = array(
                'no'        => $no++,
                'username'  => $value->username,
                'role'      => $value->role->name,
                'email'     => $value->email,
                'status'    => $value->status === 0 ? '<span class="badge bg-gradient-danger">offline</span>' : '<span class="badge bg-gradient-success">Online</span>',
                'updated_at'     => $value->status === 0 ? Carbon::parse($value->updated_at)->diffForHumans() : '<span class="badge bg-gradient-info">Available</span>',
            );
        }

        $result = array(
            "sEcho" 				=> 1,
            "iTotalRecords" 		=> count($data),
            "iTotalDisplayRecords" 	=> count($data),
            "aaData"				=> $data
        );
        
        return json_encode($result);
    }

    public function show_edit_profile()
    {
        $title  = "Edit Profile";
        
        $user_id    = Auth::user()->id;
        $profile    = ModelProfile::where('user_id', $user_id)->first();

        $data   = [
            'title'     => $title,
            'profile'   => $profile,
            'list_activity' => [],
        ];

        return view($this->controller_name . '::edit-fields')->with($data);
    }

    public function update_profile(Request $request)
    {
        $input  = $request->all();
        $user   = Auth::user();
        
        if(@$request->profile['upload_image']){
            $file       = $request->profile['upload_image'];
            $extension  = ".".$file->extension();
            $filename   = date('YmdHi_').$user->username."_".$user->id."_".$extension;
            $file->move(public_path('assets/img/profile'), $filename);
            $input['profile']['img_path']   = 'assets/img/profile/'.$filename;
            unset($input['profile']['upload_image']);
        }

        ModelProfile::where('user_id', $user->id)->update($input['profile']);
        
        $notification_data  = [
            'user_id'   => $user->id,
            'message'   => 'User [$name] telah memperbaharui profilenya',
        ];

        ModelNotification::create([
            'notification_data' => json_encode($notification_data),
        ]);
        // dd(env('REDIS_CLIENT', '127.0.0.1'));
        event(new \App\Events\NotificationEvent($input['profile']));

        return redirect('/home');
    }
}
