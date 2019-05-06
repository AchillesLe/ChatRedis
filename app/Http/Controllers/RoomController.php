<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;
use Auth;
use Validator;
use App\Events\RoomEvent;

class RoomController extends Controller
{
    public function getAllRoom(){
        $allRoom = Room::all();
        return response()->json( [ 'status' => TRUE , 'data' => $allRoom ] );
    }
    public function getMyRoom(){
        $user = Auth::user();
        $id = $user->id ;
        $myRoom = Room::where('owner_id',$id)->get();
        return response()->json( [ 'status' => TRUE , 'data' => $myRoom ] );
    }
    public function create(Request $request){
        $validator = \Validator::make( $request->all() , [
            'name' => 'required|unique:rooms|max:255',
            'description' => 'required',
        ]);
        if ( $validator->fails() ){
            return response()->json([ 'status' => FALSE , 'errors' => $validator->errors()->all() ]);
        }
        $user = Auth::user();
        $id = $user->id ;
        $room = Room::create([
            'name' =>  $request->input('name') , 
            'description' => $request->input('description') ,
            'owner_id' =>  $id,
        ]);
        if( $room ){
            event(new RoomEvent($room));
            return response()->json([ 'status' => TRUE , 'message' => 'Create a new room successfully !' , 'entry' => $room ]);
        }else{
            return response()->json([ 'status' => FALSE , 'message' => 'Create a new room fail !' ]);
        }
    }
}
