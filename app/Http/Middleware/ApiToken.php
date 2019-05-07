<?php

namespace App\Http\Middleware;

use Closure;
use App\Users_token;
class ApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $api_token = $request->header('Authorization');
        if ( !$this->check_token($api_token) ) {
            return response()->json([ 'code' => 401 , 'message' => 'Unauthorized']);
        } 
        return $next($request);
    }
    private function check_token($api_token){
        $now = date('Y-m-d h:i:s');
        $token = Users_token::where( 'token', $api_token )
                            ->where( 'expired_at','>=', $now  )->first();
        if( $token ){
            return true;
        }
        return false;      
    }
}
