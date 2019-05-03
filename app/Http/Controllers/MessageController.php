<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use Auth;
use  App\Events\MessagePosted;
class MessageController extends Controller
{
    public function index(){
        return view('chat');
    }
    public function getuserlogin(){
        $user =  Auth::user();
        return $user;
    }
    public function getMessage(){
        $message = Message::with('user')->get();
        return $message;
    }
    public function postMessage(){
        $user = Auth::user();

        $message = $user->messages()->create([
            'message' => request()->get('message')
        ]);
    
        broadcast(new MessagePosted($message, $user) )->toOthers();
    
        return ['status' => 'OK'];
    }
}
