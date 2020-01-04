<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use Auth;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function fetchMessages()
    {
        $allUsers1 = DB::table('users')->join('conversation', 'users.id', 'conversation.user_1')->where('conversation.user_2', Auth::user()->id)->get();
        $allUsers2 = DB::table('users')->join('conversation', 'users.id', 'conversation.user_2')->where('conversation.user_1', Auth::user()->id)->get();
        return array_merge($allUsers1->toArray(), $allUsers2->toArray());
    }

    public function messages($id)
    {
        /*$checkCon = DB::table('conversation')->where('user_1', Auth::user()->id)->where('user_2', $id)->get();
        if(count($checkCon)!=0){
           $userMsg = DB::table('messages')->where('messages.chat_id', $checkCon[0]->chat_id)->get();
           return $userMsg;
        }else{
            echo "no messages";
        }*/

        $userMsg = DB::table('messages')->join('users', 'users.id', 'messages.user_from')->where('messages.chat_id', $id)->get();
        return $userMsg;
    }

    public function user()
    {
        return Auth::id();
    }

    public function sendMessages(Request $request) {
        $conID = $request->conID;
        $msg = $request->msg;

        $fetch_userTo = DB::table('messages')->where('chat_id', $conID)->where('user_to', '!=', Auth::user()->id)->get();
        $userTo = $fetch_userTo[0]->user_to;

        $sendM = DB::table('messages')->insert([
            'user_to' => $userTo,
            'user_from' => Auth::user()->id,
            'msg' => $msg,
            'status' => 1,
            'chat_id' =>$conID, 
        ]);
        if($sendM) {
            $userMsg = DB::table('messages')->join('users', 'users.id', 'messages.user_from')->where('messages.chat_id', $conID)->get();
            return $userMsg;
        }
    }

    public function sendNewMessages(Request $request) {
        $msg = $request->msg;
        $contID = $request->contID;
        $myID = Auth::user()->id;

        $checkCon1 = DB::table('conversation')->where('user_1', $myID)->where('user_2', $contID)->get();
        $checkCon2 = DB::table('conversation')->where('user_2', $myID)->where('user_1', $contID)->get();

        $allCons = array_merge($checkCon1->toarray(), $checkCon2->toarray());

        if(count($allCons)!=0) {
            $conID_old = $allCons[0]->chat_id;

            $MsgSent = DB::table('messages')->insert([
                'user_from' => $myID,
                'user_to' => $contID,
                'msg' => $msg,
                'chat_id' => $conID_old,
                'status' => 1,
            ]);
        }else{
            $conID_new = DB::table('conversation')->insertGetId([
                'user_1' => $myID,
                'user_2' => $contID
            ]);
            echo $conID_new;

            $MsgSent = DB::table('messages')->insert([
                'user_from' => $myID,
                'user_to' => $contID,
                'msg' => $msg,
                'chat_id' => $conID_new,
                'status' => 1,
            ]);
        }

    }

}
