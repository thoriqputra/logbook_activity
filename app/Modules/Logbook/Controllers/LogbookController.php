<?php

namespace App\Modules\Logbook\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Response;
use File;
use Excel;
use Carbon\Carbon;
Use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Models\ModelSupportDepartment;
use App\Models\ModelActivity;
use App\Models\ModelActivityType;
use App\Models\ModelRequestor;
use App\Models\ModelChannelRequestor;
use App\Models\ModelListActivity;
use App\Models\ModelNotification;

class LogbookController extends Controller
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

    public $controller_name = 'Logbook';

    public function index(){
        $title          = "Logbook";

        return view($this->controller_name . '::index', compact('title'));
    }

    public function create(){
        $title          = "Create";

        $support_department = ModelSupportDepartment::with('activity')->get();
        $activity_type      = ModelActivityType::all();
        $channel_requestor  = ModelChannelRequestor::all();
        $requestor          = ModelRequestor::all();
        // $optionSupportDepartment    = "";
        // $optionActivityType         = "";
        // $optionChanelRequestor      = "";
        // $optionRequestor            = "";

        // $no_support_department = 1;
        // foreach($support_department as $val){
        //     $optionSupportDepartment   .= '<option value="'.$val->id.'">'.$no_support_department++.'. '.$val->name.'</option>';
        // }

        // $no_activity_type   = 1;
        // foreach($activity_type as $val){
        //     $optionActivityType   .= '<option value="'.$val->id.'">'.$no_activity_type++.'. '.$val->name.'</option>';
        // }

        // $no_channel_requestor   = 1;
        // foreach($channel_requestor as $val){
        //     $optionChanelRequestor   .= '<option value="'.$val->id.'">'.$no_channel_requestor++.'. '.$val->name.'</option>';
        // }

        // $no_requestor   = 1;
        // foreach($requestor as $val){
        //     $optionRequestor   .= '<option value="'.$val->id.'">'.$no_requestor++.'. '.$val->type.' - '.$val->name.'</option>';
        // }

        $data = [
            "title"                 => $title,
            "support_department"    => $support_department,
            "activity_type"         => $activity_type,
            "requestor"             => $requestor,
            "channel_requestor"     => $channel_requestor,
            // "support_department"    => $optionSupportDepartment,
            // "activity_type"         => $optionActivityType,
            // "requestor"             => $optionRequestor,
            // "channel_requestor"     => $optionChanelRequestor,
        ];

        return view($this->controller_name . '::create')->with($data);
    }

    public static function getListActivity(){
        $user           = \Auth::user();
        
        if($user->role_id === 1){
            $listActivity   = ModelListActivity::with('support_department', 'activity', 'activityType', 'channel_requestor', 'requestor', 'user.profile')
            ->orderBy('created_at', 'desc')
            ->get();
        }else{
            $listActivity   = ModelListActivity::with('support_department', 'activity', 'activityType', 'channel_requestor', 'requestor', 'user.profile')
            ->orderBy('created_at', 'desc')
            ->where('user_id', $user->id)
            ->get();
        }

        $data   = [];
        $no     = 1;
        foreach ($listActivity as $key => $value) {
            if(strlen($value->requestor_id) <= 1){
                $requestor  = ModelRequestor::select('name')->where('id', $value->requestor_id)->first();

                $requestor_name   = $requestor->name;
            }else if(strlen($value->requestor_id) >= 2){
                $explode_requestor_id   = explode(",", $value->requestor_id);
                $implode_requestor = "";
    
                for($x = 0; $x < count($explode_requestor_id); $x++){
                    $requestor  = ModelRequestor::select('name')->where('id', $explode_requestor_id[$x])->first();
    
                    $name_requestor[]   = $requestor->name;
                }
    
                for($y = 0; $y < count($explode_requestor_id); $y++){
                    $implode_requestor .= $name_requestor[$y].", ";
                }
    
                $requestor_name  = substr_replace($implode_requestor, "", -2);
            }

            $data[]   = array(
                'no'                    => $no++,
                'support_department'    => $value->support_department->name,
                'activity_name'         => $value->activity->name,
                'activity_type'         => $value->activityType->name,
                'detail_activity'       => $value->detail_activity,
                'remarks'               => $value->remarks,
                'start_date'            => $value->start_date,
                'end_date'              => $value->end_date,
                'requestor'             => $requestor_name,
                'channel_requestor'     => $value->channel_requestor->name,
                'executor'              => $value->user->profile->name,
                'url'                   => $value->url,
                // 'additional_info'       => $value->additional_info,
                'action'                => '
                <button type="button" class="btn btn-sm btn-info" value="'.$value->id.'" onclick="viewDetail(this.value);">
                    <i class="fa fa-eye"></i>
                    Detail
                </button>'
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

    // public function getDataCreate(){
    //     $support_department = ModelSupportDepartment::with('activity')->get();
    //     $activity_type      = ModelActivityType::all();
    //     $channel_requestor  = ModelChannelRequestor::all();
    //     $requestor          = ModelRequestor::all();
    //     $optionSupportDepartment    = "";
    //     $optionActivityType         = "";
    //     $optionChanelRequestor      = "";
    //     $optionRequestor            = "";

    //     $no_support_department = 1;
    //     foreach($support_department as $val){
    //         $optionSupportDepartment   .= '<option value="'.$val->id.'">'.$no_support_department++.'. '.$val->name.'</option>';
    //     }

    //     $no_activity_type   = 1;
    //     foreach($activity_type as $val){
    //         $optionActivityType   .= '<option value="'.$val->id.'">'.$no_activity_type++.'. '.$val->name.'</option>';
    //     }

    //     $no_channel_requestor   = 1;
    //     foreach($channel_requestor as $val){
    //         $optionChanelRequestor   .= '<option value="'.$val->id.'">'.$no_channel_requestor++.'. '.$val->name.'</option>';
    //     }

    //     $no_requestor   = 1;
    //     foreach($requestor as $val){
    //         $optionRequestor   .= '<option value="'.$val->id.'">'.$no_requestor++.'. '.$val->type.' - '.$val->name.'</option>';
    //     }

    //     $result = [
    //         "support_department"    => $optionSupportDepartment,
    //         "activity_type"         => $optionActivityType,
    //         "requestor"             => $optionRequestor,
    //         "channel_requestor"     => $optionChanelRequestor,
    //     ];

    //     return $result;
    // }

    public function getDepartmentActivity($department_id){
        $activity   = ModelActivity::where("status", "Active")->where('support_department_id', $department_id)->get();

        $result = [
            "activity"  => $activity,
        ];

        return $result;
    }

    public static function doSubmit(Request $request, $page){
        $input 	= $request->all();

        if($page === "form"){
            $validator = Validator::make($input,[
                'start_date'    => 'required|string',
                'end_date'      => 'required|string',
                'duration'      => 'required|string',
                'support_department_name' 	=> 'required|string',
                'activity_name'     => 'required|string',
                'activity_type'     => 'required|string',
                'detail_activity'   => 'required|string',
                'requestor' 	    => 'required',
                'channel_requestor' => 'required|string',
                'executor'          => 'required|string',
            ]);

            if ($validator->fails())
            {
                $status = $validator->errors()->all();
                
                foreach ($status as $res){
                    $result[] 	= '<li>'.$res.'</li>';
                }

                $data['result'] = [
                    'status'    => "FAILED",
                    'message'   => '<div class="alert alert-danger"><h4>Result</h4>'.implode("", $result).'</div>',
                ];
            }else{
                $user   = \Auth::user();

                ModelListActivity::create([
                    'start_date'        => $request->start_date,
                    'end_date'          => $request->end_date,
                    'duration'          => $request->duration,
                    'support_department_id' => $request->support_department_name, 
                    'activity_id'           => $request->activity_name, 
                    'activity_type_id'      => $request->activity_type, 
                    'user_id'               => $user->id, 
                    'detail_activity'       => $request->detail_activity, 
                    'remarks'               => $request->remarks, 
                    'requestor_id'          => implode(",", $request->requestor),
                    'channel_requestor_id'  => $request->channel_requestor,
                    'url'                   => $request->url,
                ]);

                $notification_data  = json_encode([
                    'user_id'   => $user->id,
                    'message'   => 'User [$name] telah menambahkan activity',
                ]);

                ModelNotification::create([
                    'notification_data' => $notification_data 
                ]);

                event(new \App\Events\LogbookEvent(ModelListActivity::all()));
                event(new \App\Events\NotificationEvent());

                $data['result'] = [
                    'status'    => "SUCCESS",
                    'message'   => "List Activity telah ditambahkan !",
                ];		
            }
        }else{
            $validator = Validator::make($input,[
                'upload_file'     => 'required|mimes:xls,xlsx',
            ]);

            if ($validator->fails())
            {
                $status = $validator->errors()->all();
                
                foreach ($status as $res){
                    $result[] 	= '<li>'.$res.'</li>';
                }

                $data['result'] = [
                    'status'    => "FAILED",
                    'message'   => '<div class="alert alert-danger"><h4>Result</h4>'.implode("", $result).'</div>',
                ];
            }else{
                $file = $request->file('upload_file');
                $path = $file->getRealPath();

                $excel  = Excel::load($path)->get();
                $count  = $excel->count();
    
                if($count === 0){
                    $data['result'] = [
                        "status"    => "FAILED",
                        "message"   => "Data tidak ada yang diimport !",
                    ];
                }else{
                    $heading    = $excel->first()->keys()->toArray();
                    $header     = implode("|", $heading);
                    
                    // if($header !== "support_department|activity_name|activity_type|detail_activity|remarks|start_date|end_date|duration|requestor|channel_requestor|executor|url|additional_info"){
                    if($header !== "support_department|activity_name|activity_type|detail_activity|remarks|start_date|end_date|requestor|channel_requestor|url"){
                        $data['result'] = [
                            'status'    => "FAILED",
                            'message'   => "Format header tidak sesuai, mohon di cek kembali !",
                        ];
                    }else{
                        $data['result'] = [
                            "status"    => "SUCCESS",
                            "message"   => "Data berhasil diimport !",
                            "data"      => $excel,
                        ];
                    }
                }
            }
        }
        
        return $data;
    }

    public static function doImport(Request $request, $count){
        $input 	    = $request->all();
        $success    = 1;
        $failed     = 1;
        $c_success  = 0;
        $c_failed   = 0;
        
        for($x = 0; $x < $count; $x++){
            $user           = \Auth::user();
            $department     = ModelSupportDepartment::where("name", $request->department_name[$x])->first();
            $activity       = ModelActivity::where("name", $request->activity_name[$x])->first();
            $activity_type  = ModelActivityType::where("name", $request->activity_type[$x])->first();
            $source         = ModelChannelRequestor::where("name", $request->source[$x])->first();
            $requestor      = array();

            if(strpos($request->requestor[$x], ",") !== false){            
                $implode = "";
                $checkExpRequestor  = explode(",", $request->requestor[$x]);
                $c_exp_requestor    = count($checkExpRequestor);
                
                $id = [];
                for($i = 0; $i < $c_exp_requestor; $i++){
                    $checkRequestor  = ModelRequestor::where("username", $checkExpRequestor[$i])->first();
                    $id[]            = $checkRequestor->id;
                }

                for($y = 0; $y < $c_exp_requestor; $y++){
                    $implode .= $id[$y].",";
                }
                
                $cln        = substr_replace($implode, "", -1);
                $requestor  = $cln;
            } else{  
                $checkRequestor = ModelRequestor::where("username", $request->requestor[$x])->first();
                $requestor      = $checkRequestor->id;
            }
            
            $start      = Carbon::parse($request->start_date[$x]);
            $end        = Carbon::parse($request->end_date[$x]);
            $duration   = $end->diffInHours($start);

            if($department !== null && $activity !== null && $activity_type !== null && $source !== null && $requestor !== null){
                ModelListActivity::create([
                    'support_department_id' => $department->id, 
                    'activity_id'           => $activity->id, 
                    'activity_type_id'      => $activity_type->id, 
                    'user_id'               => $user->id, 
                    'detail_activity'       => $request->detail_activity[$x], 
                    'remarks'               => $request->remarks[$x], 
                    'start_date'            => $request->start_date[$x],
                    'end_date'              => $request->end_date[$x],
                    'duration'              => $duration,
                    'requestor_id'          => $requestor,
                    'channel_requestor_id'  => $source->id,
                    // 'executor'           => $request->executor[$x],
                    // 'executor'           => $request->executor[$x],
                    'url'                   => $request->url[$x],
                    // 'additional_info'   => $request->additional_info[$x],
                ]);

                $c_success  = $success++; 
            }else{
                $c_failed   = $failed++;
            }
        }
             
        $data['result'] = [
            "c_success" => $c_success,
            "c_failed"  => $c_failed,
            "status"    => "SUCCESS",
            "message"   => "Data telah selesai diproses !"
        ];	

        return $data;
    }

    public static function doExportTemplate(Request $request){
        $rows = array(
            array(
                'support_department_id' => 'IT SIM', 
                'activity_id'           => 'Create PBI ticket via Remedy',
                'activity_type_id'      => 'BAU',
                'detail_activity'       => 'Menulis',
                'remarks'               => 'Testing',
                'start_date'            => '2022-04-06 08:00:00',
                'end_date'              => '2022-04-07 17:00:00',
                // 'duration'              => '60',
                'requestor_id'          => '18011800',
                'channel_requestor_id'  => 'Whatsapp',
                // 'executor'              => 'Thoriq Putra Kusharta',
                'url'                   => 'google.com',
                // 'additional_info'       => 'test',
            ),
            array(
                'support_department_id' => 'IT SIM', 
                'activity_id'           => 'Create PBI ticket via Remedy',
                'activity_type_id'      => 'BAU',
                'detail_activity'       => 'Menulis',
                'remarks'               => 'Testing',
                'start_date'            => '2022-04-06 08:00:00',
                'end_date'              => '2022-04-07 17:00:00',
                // 'duration'              => '60',
                'requestor_id'          => '18011800,18011841',
                'channel_requestor_id'  => 'Whatsapp',
                // 'executor'              => 'Thoriq Putra Kusharta',
                'url'                   => 'google.com',
                // 'additional_info'       => 'test',
            ),
        );

        $column[]   = array(
            'Support Department',
            'Activity Name',
            'Activity Type',
            'Detail Activity',
            'Remarks',
            'Start Date',
            'End Date',
            // 'Duration',
            'Requestor',
            'Channel Requestor',
            // 'Executor',
            'Url',
            // 'Additional Info',
        );

        foreach($rows as $val){
            $column[]   = array(
                'Support Department'    => $val["support_department_id"],
                'Activity Name'         => $val["activity_id"],
                'Activity Type'         => $val["activity_type_id"],
                'Detail Activity'       => $val["detail_activity"],
                'Remarks'               => $val["remarks"],
                'Start Date'            => $val["start_date"],
                'End Date'              => $val["end_date"],
                // 'Duration'              => $val["duration"],
                'Requestor'             => $val["requestor_id"],
                'Channel Requestor'     => $val["channel_requestor_id"],
                // 'Executor'              => $val["executor"],
                'Url'                   => $val["url"],
                // 'Additional Info'       => $val["additional_info"],
            );
        }

        Excel::create('Template File List Activity',function($excel) use($column){
            $excel->setTitle('Sample List Activity');
            $excel->sheet('List Activity', function ($sheet) use($column) {
                $sheet->fromArray($column, null, 'A1', false, false);
            });
        })->download('xlsx');
    }

    public static function doExportDetail($id){
        $listActivity   = ModelListActivity::with('support_department', 'activity', 'activityType', 'channel_requestor', 'requestor', 'user.profile')->findOrFail($id);

        $rows = array(
            array(
                'support_department_id'     => $listActivity->support_department->name, 
                'activity_id'               => $listActivity->activity->name,
                'activity_type_id'          => $listActivity->activityType->name,
                'detail_activity'           => $listActivity->detail_activity,
                'remarks'                   => $listActivity->remarks,
                'start_date'                => $listActivity->start_date,
                'end_date'                  => $listActivity->end_date,
                'duration'                  => $listActivity->duration,
                'requestor_id'              => @$listActivity->requestor->name,
                'channel_requestor_id'      => $listActivity->channel_requestor->name,
                'executor'                  => $listActivity->user->profile->name,
                'url'                       => $listActivity->url,
            ),
        );

        $column[]   = array(
            'Support Department',
            'Activity Name',
            'Activity Type',
            'Detail Activity',
            'Remarks',
            'Start Date',
            'End Date',
            'Duration',
            'Requestor',
            'Channel Requestor',
            'Executor',
            'Url',
        );

        foreach($rows as $val){
            $column[]   = array(
                'Support Department'    => $val["support_department_id"],
                'Activity Name'         => $val["activity_id"],
                'Activity Type'         => $val["activity_type_id"],
                'Detail Activity'       => $val["detail_activity"],
                'Remarks'               => $val["remarks"],
                'Start Date'            => $val["start_date"],
                'End Date'              => $val["end_date"],
                'Duration'              => $val["duration"],
                'Requestor'             => $val["requestor_id"],
                'Channel Requestor'     => $val["channel_requestor_id"],
                'Executor'              => $val["executor"],
                'Url'                   => $val["url"],
            );
        }

        Excel::create('Detail List Activity',function($excel) use($column){
            $excel->setTitle('Sample List Activity');
            $excel->sheet('List Activity', function ($sheet) use($column) {
                $sheet->fromArray($column, null, 'A1', false, false);
            });
        })->download('xlsx');
    }

    public static function doExportTable(){
        $listActivity   = ModelListActivity::with('support_department', 'activity', 'activityType', 'channel_requestor', 'requestor', 'user.profile')->get();
        
        $rows   = [];
        foreach($listActivity as $v){
            if(strlen($v->requestor_id) > 1){
                $arrRequestor   = explode(",", $v->requestor_id);
                $requestor  = ModelRequestor::select('name')->whereIn('id', $arrRequestor)->get();
                
                $requestor_name    = [];
                foreach($requestor  as $res){
                    $requestor_name[]  = $res->name;
                }

                $imp_requestor  = implode(", ", $requestor_name);
            }

            $rows[] = array(
                    'support_department_id' => $v->support_department->name, 
                    'activity_id'           => $v->activity->name,
                    'activity_type_id'      => $v->activityType->name,
                    'detail_activity'       => $v->detail_activity,
                    'remarks'               => $v->remarks,
                    'start_date'            => $v->start_date,
                    'end_date'              => $v->end_date,
                    'duration'              => $v->duration,
                    'requestor_id'          => strlen($v->requestor_id) > 1 ? $imp_requestor : $v->requestor->name,
                    'channel_requestor_id'  => $v->channel_requestor->name,
                    'executor'              => $v->user->profile->name,
                    'url'                   => $v->url,
                    // 'additional_info'       => $v->additional_info,
            );
        }

        $column[]   = array(
            'Support Department',
            'Activity Name',
            'Activity Type',
            'Detail Activity',
            'Remarks',
            'Start Date',
            'End Date',
            'Duration',
            'Requestor',
            'Chanel Requestor',
            'Executor',
            'Url',
        );

        foreach($rows as $val){
            $column[]   = array(
                'Support Department'    => $val["support_department_id"],
                'Activity Name'         => $val["activity_id"],
                'Activity Type'         => $val["activity_type_id"],
                'Detail Activity'       => $val["detail_activity"],
                'Remarks'               => $val["remarks"],
                'Start Date'            => $val["start_date"],
                'End Date'              => $val["end_date"],
                'Duration'              => $val["duration"],
                'Requestor'             => $val["requestor_id"],
                'Chanel Requestor'      => $val["channel_requestor_id"],
                'Executor'              => $val["executor"],
                'Url'                   => $val["url"],
            );
        }

        Excel::create('Detail List Activity',function($excel) use($column){
            $excel->setTitle('Daftar Informasi List Activity');
            $excel->sheet('List Activity', function ($sheet) use($column) {
                $sheet->fromArray($column, null, 'A1', false, false);
            });
        })->download('xlsx');
    }

    public static function getDetailListActivityById($id_list_activity)
    {
        $detailListActivity   = ModelListActivity::with('support_department', 'activity', 'activityType', 'channel_requestor', 'requestor', 'user.profile')
        ->where('id', $id_list_activity)
        ->orderBy('created_at', 'desc')
        ->first();
        
        $json   = json_decode(json_encode($detailListActivity, true), true);
        
        if(strlen($detailListActivity->requestor_id) > 1){
            $explode_requestor_id    = explode(",", $detailListActivity->requestor_id);
            $requestor  = ModelRequestor::select('name')->whereIn('id', $explode_requestor_id)->get()->toArray();

            $no = 1;
            foreach($requestor as $key => $rows){
                $requestor_name[] = $no++.". ".$rows['name'];
            }

            $json['requestor']['name']  = implode("<br>", $requestor_name);
        }
        
        $data   = $json;
        
        return response()->json($data, 200);
    }
}
