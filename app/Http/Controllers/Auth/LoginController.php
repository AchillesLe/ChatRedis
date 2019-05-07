<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Users_token;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    //============================================= for api
    public function do_login(){
        $email = request('email');
        $password = request('password');
        if ( Auth::attempt([ 'email' => $email , 'password' => $password ]) ) {
            $entry = $this->generate_token( Auth::user()->id );
            $user = Auth::user();
            $data = array_merge(
                [
                    'id'=>$user->id,
                    'name'=>$user->name,
                    'email'=>$user->email,
                ],[
                    'token' => $entry->token ,
                    'expired_at' => $entry->expired_at ,
                ]
            );
            return response()->json(['status'=>TRUE , 'data' => $data ]);
        }else{
            return response()->json(['status'=>FALSE , 'message' =>'credentials incorrect!' ]);
        }
    }
    //============================================= for api
    private function generate_token( $id_user ){
        $token = Hash::make($id_user.'_'.Str::random(100).time());
        $expired = date('Y-m-d h:i:s' , strtotime("+2 hours") );
        $now =  date('Y-m-d h:i:s');
        $user = Users_token::where('id_user',$id_user )->where('expired_at','>=',$now )->first();
        if( $user ){
            Users_token::where('id',$user->id )->where('expired_at','>=', $now )->update([
                'token' => $token ,
                'expired_at' =>$expired
            ]);
            $entry =  Users_token::where('id_user',$id_user )->where('expired_at','>=',$now )->get()[0];
        }else{
            Users_token::where('id_user',$id_user )->where('expired_at','<',$now )->delete();
            $entry = Users_token::create([
                'id_user' => $id_user ,
                'token' => $token ,
                'expired_at'=> $expired
            ]);
        }
        return $entry;
    }
    public function api_logout(Request $request){
        $api_token = $request->header('Authorization');
        Users_token::where('token',$api_token )->delete();
        return response()->json(['status'=>TRUE , 'message' =>'logout successfluly!' ]);
    }
    
}
