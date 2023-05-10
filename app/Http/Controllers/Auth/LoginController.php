<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Validator;
use Response;
use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'home';

    /**
     * Create a new controller instance.
     *
     * @return void
     **/

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            $userId = \Auth::user()->id; 
            User::where('id', $userId)->update([
                'status'    => 1
            ]);
            
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function showLoginForm()
    {
        if(Auth::check())
        {
            return redirect('/');
        }

        $title  = "Login";
        
        return view('auth.login', compact('title'));
    }

    protected function validateLogin(Request $request)
    {   
        $rules = [
            $this->username()   => 'required|string',
            'password'          => 'required|string',
        ];
        
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorResponse = $this->validationErrorsToString($validator->errors());
            
            return response()->json(['message' => 'The given data was invalid.', 'errors' => $errorResponse],400);
        }
    }  
    
    private function validationErrorsToString($errArray) {
        $valArr = array();
  
        foreach ($errArray->toArray() as $key => $value) {
            $valArr[$key] = $value[0];
        }
    
        return $valArr;
    }

    protected function credentials(Request $request)
    {
        $field = filter_var($request->get($this->username()))
        ? $this->username() : 'username';

        return [
            $field => $request->get($this->username()),
            'password' => $request->password,
        ];
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();
        
        $this->clearLoginAttempts($request);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'user' => $this->guard()->user(),
            ]);
        }

        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
    }

    protected function authenticated(Request $request, $user)
    {
        $credentials = $request->only('username', 'password');
       
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended($redirectTo);
        }

        return redirect('/');
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $rules = [
             $this->username()  => 'required|string',
            'password'          => 'required|string',
        ];
        
        $validator  = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            $status = $validator->errors()->all();
            
            foreach ($status as $res){
                $result[]   = $res.'<br/>';
            }

            $data['status'] = "VALIDATION";
            $data['result'] = implode("", $result);

            return $data;
        }

        $data['status']     = "FAILED";
        $data['notice']     = [trans('auth.checking')];
        
        return $data;
    }

    public function username()
    {
        return 'username';
    }

    public function logout(Request $request)
    {
        $userId = \Auth::user()->id; 
        User::where('id', $userId)->update([
            'status'        => 0,
            'updated_at'    => date("Y-m-d H:i:s"),
        ]);
        
        $this->guard()->logout();

        $request->session()->invalidate();
        
        $request->session()->flush();

        return redirect('login')->with('notification','SUCCESS');
    }

    protected function guard()
    {
        return Auth::guard();
    }
}
