<?php

namespace App\Modules\UserManagement\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\ModelProfile;
use App\Models\ModelRole;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
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

    public $controller_name = 'UserManagement';

    public function index(){
        $title  = "User Management";

        return view($this->controller_name . '::index' ,compact('title'));
    }

    public static function getUserList(){
        $userList   = User::with('role')->orderBy('created_at', 'desc')->get();

        $data   = [];
        $no     = 1;
         
        foreach ($userList as $key => $value) {
            $data[]   = array(
                'no'        => $no++,
                'username'  => $value->username,
                'role'      => $value->role->name,
                'email'     => $value->email,
                'action'    => '
                <button type="button" class="btn btn-default btn-icon btn-sm" value="'.$value->id.'" onclick="viewEdit(this);">
                    <span class="btn-inner--icon"><i class="fa fa-edit fa-lg"></i></span>
                    Edit
                </button> 
                <button type="button" class="btn btn-danger btn-sm" value="'.$value->id.'" data-name="'.$value->name.'" onclick="doRemove(this);">
                    <i class="fa fa-ban fa-lg"></i> 
                    Remove    
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
    
    public static function get_data_user_by_user_id($user_id)
    {
        $role       = ModelRole::all();
        
        $user       = null;
        $profile    = null;
        if($user_id !== "0"){
            $user       = User::findOrFail($user_id);
            $profile    = ModelProfile::where('user_id', $user_id)->first();
        }

        $result = [
            'role'      => $role,
            'user'      => $user,
            'profile'   => $profile,
        ];

        return $result;
    }

    public static function doSubmit(Request $request){
        $input 	= $request->all();

        $validator = Validator::make($input,[
            'role'      => 'required|integer',
            'username'  => 'required|string',
            'name'      => 'required|string',
            'job'       => 'required|string',
            'email'     => 'required|email',
            'password' 	=> 'required|string',
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
            User::create([
                'role_id'   => $request->role, 
                'username'  => $request->username, 
                'email'     => $request->email, 
                'password'  =>  Hash::make($request->notes), 
            ]);

            $user   = User::where('username', $request->username)->first();

            ModelProfile::create([
                'name'      => $request->name,
                'user_id'   => $user->id,
                'job'       => $request->job,
            ]);

            $data['result'] = [
                'status'    => "SUCCESS",
                'message'   => "User <b>".$request->name."</b> telah ditambahkan !",
            ];		
        }

        return $data;
    }
    
    public function doUpdate(Request $request, $user_id)
    {
        User::where('id', $user_id)->update([
            'role_id'   => $request->role,
            'username'  => $request->username,
            'email'     => $request->email,
            'password'  => \Hash::make($request->password),
        ]);

        ModelProfile::where('user_id', $user_id)->update([
            'name'  => $request->name,
            'job'   => $request->job,
        ]);

        $data['result'] = [
            'status'    => "SUCCESS",
            'message'   => "User <b>".$request->name."</b> telah diperbaharui !",
        ];		

        return $data;
    }

    public static function doRemove($id, $name){
        $user   = User::where("id", $id)->delete();

        $data["result"] = "User <b>".$name."</b> telah di hapus !";

        return $data;
    }
}
