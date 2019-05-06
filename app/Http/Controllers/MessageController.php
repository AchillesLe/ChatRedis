<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use Auth;
use App\Events\MessagePosted;
use App\Room;

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
        $id= request('id');
        $info = Room::where('id',$id)->get()[0];
        $message = Message::with('user')->where('room_id',$id)->get();
        return response()->json([ 'messages'=>$message , 'info' => $info]);
    }

    public function postMessage(){
        $user = Auth::user();
        $message = Message::create([
            'message' => request('message'),
            'room_id' => request('room_id'),
            'user_id' => $user->id
        ]);
        $message['user'] = $user;
        broadcast(new MessagePosted($message, $user) )->toOthers();
    
        return response()->json([ 'entry' => $message  ]);
    }

    public function room(){
        return view('chatroom');
    }
}
