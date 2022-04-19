<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    public function get_tab_chat(Request $request){
        $your_id = $request->your_id;
        $your_friend_id = $request->your_friend_id;

        //* room_code la: user_id1-user_id2: phòng chat có 2 thành viên: user_id1 và user_id2
        $room_code = MainController::get_room_code($your_friend_id, $your_id);
        
        //* Kiểm tra đã có room_code và participants chưa
        //TODO: Nếu chưa có thì thêm vào table
        $has_room_code = DB::table('room_chat')->where('room_code',$room_code)->first();
        if ($has_room_code == null){
            DB::table('room_chat')->insert(['room_code'=>$room_code,'type'=>0]);
        }
        $has_participants_first = DB::table('participants')->where('room_code',$room_code)->where('user_id',$your_id)->first();
        if ($has_participants_first == null){
            DB::table('participants')->insert([
                ['room_code'=>$room_code,'user_id'=>$your_id,'status_seen'=> 1]
            ]);
        }
        $has_participants_second = DB::table('participants')->where('room_code',$room_code)->where('user_id',$your_friend_id)->first();
        if ($has_participants_second == null){
            DB::table('participants')->insert([
                ['room_code'=>$room_code,'user_id'=>$your_friend_id,'status_seen'=> 0]
            ]);
        }

        $your_friend = DB::table('users')->join('participants','users.id','participants.user_id')->select('users.id','name','avatar','status_seen','status_online')->where('room_code',$room_code)->where('users.id',$your_friend_id)->first();
        
        $is_online = $your_friend->status_online;
        //1: online, 0:offline
        $is_online = $is_online==1?'online':'';

        $is_seen = $your_friend->status_seen;
        //1: seen, 0:unseen
        $is_seen = $is_seen==1?'seen':'';

        // $messages = DB::table('messages')->select('user_id','message','time')->where('room_code',$room_code)->orderBy('time','desc')->offset(0)->limit(11)->get();
        $messages = Message::where('room_code', $room_code)->orderBy('time', 'desc')->offset(0)->limit(11)->with('images')->get()->toArray();

        return response()->json(['friend_id'=>$your_friend->id, 'friend_name'=>$your_friend->name, 'friend_avatar'=>$your_friend->avatar, 'is_seen'=>$is_seen, 'is_online'=>$is_online, 'messages'=>$messages]);
    }

    public function get_more_messages(Request $request){
        $your_id = $request->your_id;
        $your_friend_id = $request->your_friend_id;
        $current_nums_row = $request->current_nums_row;
        
        $your_friend = DB::table('users')->where('id',$your_friend_id)->first();
        
        //* room_code la: user_id1-user_id2: phòng chat có 2 thành viên: user_id1 và user_id2
        $room_code = MainController::get_room_code($your_friend_id, $your_id);
        
        // $data = DB::table('messages')->select('user_id','message','time')
        //                             ->where('room_code',$room_code)->orderBy('time','desc')
        //                             ->offset($current_nums_row)->limit(11)->get();
        $data = Message::where('room_code', $room_code)->orderBy('time', 'desc')->offset($current_nums_row)->limit(11)->with('images')->get()->toArray();

        return response()->json(['data'=>$data, 'friend_avatar'=>$your_friend->avatar]);
    }
    
    public function send_message(Request $request){
        $files = $request->file('f_media');
        $data = array();
        $data['message'] = htmlspecialchars($request->message);
        $data['time_send'] = $request->time_send;
        $data['user_id'] = $request->user_id;
        $data['receive_id'] = $request->receive_id;
        $data['friend_avatar'] = User::find($request->user_id)->avatar;
        $data['your_avatar'] = User::find($request->receive_id)->avatar;
        $data['images'] = [];
        $data['images_type'] = [];
        // room_code là id1-id2 với id1 < id2
        $room_code = MainController::get_room_code($data['user_id'],$data['receive_id']);

        // $data['time_send] đang là kiểu number (vd: 1658932485948), cần chuyển sang định dạng khác
        $time_send = Carbon::createFromTimestampMs($data['time_send'], 'Asia/Ho_Chi_Minh')->format('Y-m-d\TH:i:s');

        // Thêm message
        $messageId = DB::table('messages')->insertGetId(['room_code'=>$room_code, 'message'=>$data['message'], 'user_id'=>$data['user_id'], 'time' => $time_send]);
        
        if (!empty($files)) {
            foreach($files as $index => $file) {
                if ($file) {
                    $mime = $file->getMimeType();
                    if (strstr($mime, "video/")){
                        $type = config('status.video');
                    } else if(strstr($mime, "image/")){
                        $type = config('status.image');
                    }
                    $path = $file->storeAs('media', "message$index-" . $request->time_send . '.' . $file->getClientOriginalExtension(), 'public');
                    $url = Storage::disk('public')->url($path);
                    if (config('status.port')) {
                        $url = str_replace('localhost', 'localhost:' . config('status.port'), $url);
                    }
                    Image::create([
                        'name' => "message$index-" . $request->time_send . '.' . $file->getClientOriginalExtension(),
                        'url' => $url,
                        'type' => $type,
                        'message_id' => $messageId
                    ]);
                    $data['images'][] = $url;
                    $data['images_type'][] = $type;
                }
            } 
        }
        
        // status_seen => 0 = 'unseen'
        DB::table('participants')->where('user_id',$data['receive_id'])->where('room_code',$room_code)->update(['status_seen'=>0]);

        return $data;
    }

    public function seen_message(Request $request){
        $data['user_id'] = $request->user_id;
        $data['friend_id'] = $request->friend_id;
        $room_code = MainController::get_room_code($data['user_id'], $data['friend_id']);
        DB::table('participants')->where('user_id',$data['user_id'])->where('room_code',$room_code)
                                ->update(['status_seen'=>1]);
        return $data;
    }

    public function search_friends(Request $request){
        $user_id = $request->user_id;
        $search_value = $request->search_value;

        //Lấy ra những người là: bạn bè (0: friend) và bạn chat (1: only chat)
        $friends_and_chat = DB::table('users')->join('relationships',function($join) use($user_id){
            $join->on('users.id','=',DB::raw("IF (relationships.user_first = $user_id, relationships.user_second, relationships.user_first)"));
        })
        ->select('*',DB::raw("IF (relationships.user_first = $user_id, user_second, user_first) as friend_id"))
        ->where('users.status_verify',1)
        ->where(function($query) use($user_id){
            $query->where('relationships.user_first',$user_id)
                ->orWhere('relationships.user_second',$user_id);
        })
        ->whereRaw("name like N'%$search_value%'")
        ->get();
        return $friends_and_chat;
    }
}
