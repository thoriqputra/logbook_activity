<?php

namespace App\Modules\Configuration\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Response;
use App\Models\ModelSupportDepartment;
use App\Models\ModelActivity;
use App\Models\ModelActivityType;
use App\Models\ModelRequestor;
use App\Models\ModelRole;
use App\Models\ModelChannelRequestor;

class ConfigurationController extends Controller
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

    public $controller_name = 'Configuration';

    public function index(){
        $URI        = \Request::segment(2);
        $support_department = [];

        if($URI === "support_department"){
            $title  = "Configuration | Support Department";
            $view   = "view_support_department";
        }elseif($URI === "activity"){
            $support_department = ModelSupportDepartment::all();
            $title      = "Configuration | Activity";
            $view       = "view_activity";
        }elseif($URI === "activity_type"){
            $title  = "Configuration | Activity Type";
            $view   = "view_activity_type";
        }elseif($URI === "channel_requestor"){
            $title  = "Configuration | Channel Requestor";
            $view   = "view_channel_requestor";
        }elseif($URI === "requestor"){
            $title  = "Configuration | Requestor";
            $view   = "view_requestor";
        }elseif($URI === "role"){
            $title  = "Configuration | Role";
            $view   = "view_role";
        }
  
        if($support_department === []){
            return view($this->controller_name . '::' . $view, compact('title'));
        }else{
            return view($this->controller_name . '::' . $view, compact('title', 'support_department'));
        }
    }

    public function getListService($URI){
        $support_department = ModelSupportDepartment::orderBy('created_at', 'desc')->get();
        $activity       = ModelActivity::with('support_department')->orderBy('created_at', 'desc')->get();
        $activity_type  = ModelActivityType::orderBy('created_at', 'desc')->get();
        $chanel_requestor   = ModelChannelRequestor::orderBy('created_at', 'desc')->get();
        $requestor      = ModelRequestor::orderBy('created_at', 'desc')->get();
        $role           = ModelRole::orderBy('created_at', 'desc')->get();

        $data   = [];
        $no     = 1;

        if($URI === "support_department"){            
            foreach ($support_department as $key => $value) {
                $data[]   = array(
                    'no'            => $no++,
                    'name'          => $value->name,
                    'action'        => '<button type="button" class="btn btn-default" value="'.$value->id.'" onclick="viewEdit(this.value);" ><i class="fa fa-edit"></i> Edit</button> '
                );
            }
        }elseif($URI === "activity"){            
            foreach ($activity as $key => $value) {
                $data[]   = array(
                    'no'                => $no++,
                    'department_name'   => $value->support_department->name,
                    'name'              => $value->name,
                    'status'            => '<span class="badge badge-sm bg-gradient-'.($value->status === "Active" ? 'success' : 'danger').'">'.$value->status.'</span>',
                    'action'            => '<button type="button" class="btn btn-default" value="'.$value->id.'" onclick="viewEdit(this.value);" ><i class="fa fa-edit"></i> Edit</button> '
                );
            }    
        }elseif($URI === "activity_type"){            
            foreach ($activity_type as $key => $value) {
                $data[]   = array(
                    'no'                => $no++,
                    'name'              => $value->name,
                    'action'            => '<button type="button" class="btn btn-default" value="'.$value->id.'" onclick="viewEdit(this.value);" ><i class="fa fa-edit"></i> Edit</button> '
                );
            }    
        }elseif($URI === "channel_requestor"){            
            foreach ($chanel_requestor as $key => $value) {
                $data[]   = array(
                    'no'                => $no++,
                    'name'              => $value->name,
                    'action'            => '<button type="button" class="btn btn-default" value="'.$value->id.'" onclick="viewEdit(this.value);" ><i class="fa fa-edit"></i> Edit</button> '
                );
            }    
        }elseif($URI === "requestor"){            
            foreach ($requestor as $key => $value) {
                $data[]   = array(
                    'no'                => $no++,
                    'type'              => $value->type,
                    'name'              => $value->name,
                    'username'          => $value->username,
                    'action'            => '<button type="button" class="btn btn-default" value="'.$value->id.'" onclick="viewEdit(this.value);" ><i class="fa fa-edit"></i> Edit</button> '
                );
            }    
        }elseif($URI === "role"){            
            foreach ($role as $key => $value) {
                $data[]   = array(
                    'no'                => $no++,
                    'name'              => $value->name,
                    'action'            => '<button type="button" class="btn btn-default" value="'.$value->id.'" onclick="viewEdit(this.value);" ><i class="fa fa-edit"></i> Edit</button> '
                );
            }    
        }

        $result = array(
            "sEcho" 				=> 1,
            "iTotalRecords" 		=> count($data),
            "iTotalDisplayRecords" 	=> count($data),
            "aaData"				=> $data
        );
        
        return json_encode($result);
    }

    public function getDataEdit($URI, $id){
        if($URI === "support_department"){
            $support_department = ModelSupportDepartment::where('id', $id)->first();

            $result     = $support_department;
        }elseif($URI === "activity"){
            $support_department = ModelSupportDepartment::all();
            $activity   = ModelActivity::where('id', $id)->first();

            $result     = [
                "support_department"    => $support_department,
                "activity"      => $activity,
            ];
        }elseif($URI === "activity_type"){
            $activity_type  = ModelActivityType::where('id', $id)->first();

            $result         = $activity_type;
        }elseif($URI === "channel_requestor"){
            $chanel_requestor     = ModelChannelRequestor::where('id', $id)->first();

            $result     = $chanel_requestor;
        }elseif($URI === "requestor"){
            $requestor  = ModelRequestor::where('id', $id)->first();

            $result     = $requestor;
        }elseif($URI === "role"){
            $role  = ModelRole::where('id', $id)->first();

            $result     = $role;
        }
        
        return $result;
    }

    public function doSubmit(Request $request, $URI){
        $input  = $request->all();

        if($URI === "support_department"){
            $validator = Validator::make($input,[
                'name' 	                => 'required|string',
            ]);
        }elseif($URI === "activity"){
            $validator = Validator::make($input,[
                'name' 	                => 'required|string',
                'support_department_id' => 'required|string',
            ]);
        }elseif($URI === "activity_type"){
            $validator = Validator::make($input,[
                'name' 	                => 'required|string',
            ]);
        }elseif($URI === "channel_requestor"){
            $validator = Validator::make($input,[
                'name' 	                => 'required|string',
            ]);
        }elseif($URI === "requestor"){
            $validator = Validator::make($input,[
                'type'      => 'required|string',
                'name'      => 'required|string',
                'username'  => 'required|string',
            ]);
        }elseif($URI === "role"){
            $validator = Validator::make($input,[
                'name'  => 'required|string',
            ]);
        }

        if ($validator->fails())
        {
            $status = $validator->errors()->all();
            
            foreach ($status as $res){
                $result[] 	= '<li>'.$res.'</li>';
            }

            $data = [
                'status'    => "FAILED",
                'message'   => '<div class="alert alert-danger"><h4>Result</h4>'.implode("", $result).'</div>',
            ];
        }else{
            if($URI === "support_department"){
                ModelSupportDepartment::create([
                    'name'  => $request->name, 
                ]);
        
                $data['status']	    = "SUCCESS";
                $data['message']    = "Department <b>".$request->name."</b> berhasil di tambahkan !";
            }elseif($URI === "activity"){
                ModelActivity::create([
                    'support_department_id' => $request->support_department_id, 
                    'name'          => $request->name, 
                    'status'        => ($request->status === "on" ? "Active" : "Inactive"), 
                ]);
        
                $data['status']	    = "SUCCESS";
                $data['message']    = "Activity Name <b>".$request->name."</b> berhasil di tambahkan !";
            }elseif($URI === "activity_type"){
                ModelActivityType::create([
                    'name'  => $request->name, 
                ]);
        
                $data['status']	    = "SUCCESS";
                $data['message']    = "Activity Type Name <b>".$request->name."</b> berhasil di tambahkan !";
            }elseif($URI === "channel_requestor"){
                ModelChannelRequestor::create([
                    'name'  => $request->name, 
                ]);
        
                $data['status']	    = "SUCCESS";
                $data['message']    = "Source Name <b>".$request->name."</b> berhasil di tambahkan !";
            }elseif($URI === "requestor"){
                ModelRequestor::create([
                    'type'      => $request->type, 
                    'name'      => $request->name, 
                    'username'  => $request->username, 
                ]);
        
                $data['status']	    = "SUCCESS";
                $data['message']    = "Requestor Name <b>".$request->name."</b> berhasil di tambahkan !";
            }elseif($URI === "role"){
                ModelRole::create([
                    'name'  => $request->name, 
                ]);
        
                $data['status']	    = "SUCCESS";
                $data['message']    = "Role Name <b>".$request->name."</b> berhasil di tambahkan !";
            }
        }

        return $data;
    }

    public function doUpdate(Request $request, $URI, $id){
        $input  = $request->all();

        if($URI === "support_department"){
            $validator = Validator::make($input,[
                'name' 	                => 'required|string',
            ]);
        }elseif($URI === "activity"){
            $validator = Validator::make($input,[
                'name' 	                => 'required|string',
                'support_department_id' => 'required|string',
            ]);
        }elseif($URI === "activity_type"){
            $validator = Validator::make($input,[
                'name' 	                => 'required|string',
            ]);
        }elseif($URI === "channel_requestor"){
            $validator = Validator::make($input,[
                'name' 	                => 'required|string',
            ]);
        }elseif($URI === "requestor"){
            $validator = Validator::make($input,[
                'type'  => 'required|string',
                'name'  => 'required|string',
            ]);
        }elseif($URI === "role"){
            $validator = Validator::make($input,[
                'name'  => 'required|string',
            ]);
        }

        if ($validator->fails())
        {
            $status = $validator->errors()->all();
            
            foreach ($status as $res){
                $result[] 	= '<li>'.$res.'</li>';
            }

            $data = [
                'status'    => "FAILED",
                'message'   => '<div class="alert alert-danger"><h4>Result</h4>'.implode("", $result).'</div>',
            ];
        }else{
            if($URI === "support_department"){
                ModelSupportDepartment::where("id", $id)->update([
                    'name'  => $request->name, 
                ]);
        
                $data['status']	    = "SUCCESS";
                $data['message']    = "Department <b>".$request->name."</b> berhasil di perbaharui !";
            }elseif($URI === "activity"){
                ModelActivity::where("id", $id)->update([
                    'support_department_id' => $request->support_department_id, 
                    'name'          => $request->name, 
                    'status'        => ($request->status === "on" ? "Active" : "Inactive"), 
                ]);
        
                $data['status']	    = "SUCCESS";
                $data['message']    = "Activity Name <b>".$request->name."</b> dan Status berhasil di perbaharui !";
            }elseif($URI === "activity_type"){
                ModelActivityType::where("id", $id)->update([
                    'name'  => $request->name, 
                ]);
        
                $data['status']	    = "SUCCESS";
                $data['message']    = "Activity Type Name <b>".$request->name."</b> berhasil di perbaharui !";
            }elseif($URI === "channel_requestor"){
                ModelChannelRequestor::where("id", $id)->update([
                    'name'  => $request->name, 
                ]);
        
                $data['status']	    = "SUCCESS";
                $data['message']    = "Source Name <b>".$request->name."</b> berhasil di perbaharui !";
            }elseif($URI === "requestor"){
                ModelRequestor::where("id", $id)->update([
                    'type'      => $request->type, 
                    'name'      => $request->name, 
                    'username'  => $request->username, 
                ]);
        
                $data['status']	    = "SUCCESS";
                $data['message']    = "Requestor Name <b>".$request->name."</b> berhasil di perbaharui !";
            }elseif($URI === "role"){
                ModelRole::where("id", $id)->update([
                    'name'  => $request->name, 
                ]);
        
                $data['status']	    = "SUCCESS";
                $data['message']    = "Role Name <b>".$request->name."</b> berhasil di perbaharui !";
            }
        }

        return $data;
    }
}
