<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ChatFavourite;
use App\Models\ChatMessage;
use Pusher\Pusher;
class ChatController extends Controller
{
    public function index(){
        // dd('ss');
        $data['chatfavourites']= ChatFavourite::where('user_deleted',0)->with('User')->latest()->get();
        return view('admin.Chat.index',compact('data'));
    }
     public function store(Request $request)
    {
        return response()->json($request);

        $exists = ChatFavourite::where('user_id', 24)->exists();
        if (!$exists) {
            // create a new chatfavourite record
            $chatfavourite= ChatFavourite::create([
                'user_id' => $request->user_id,
                'admin_id' => 1,
            ]);
            $data['chatfavourite']= $chatfavourite;
            if ($request->hasFile('body')) {
                $filePath = $request->file('body')->store('uploads');

                // create a new chatmessage instance with the file path
                $data['chatdata'] = ChatMessage::create([
                    'chat_favourites_id'=> $chatfavourite->id ,
                    'sender_type'=>$request->sender_type,
                    'body'=>$filePath,
                ]);
            } else {
                // request body does not include a file
                // create a new chatmessage instance without the file path
                $data['chatdata'] = ChatMessage::create([
                    'chat_favourites_id'=> $chatfavourite->id,
                    'sender_type'=>$request->sender_type,
                    'body'=>$request->body,
                ]);
            }
        }else{
            if ($request->hasFile('body')) {
                $filePath = $request->file('body')->store('uploads');
                // create a new chatmessage instance with the file path
                $data['chatdata'] = ChatMessage::create([
                    'chat_favourites_id'=> $request->chatfavourites_id ,
                    'sender_type'=>$request->sender_type,
                    'body'=>$filePath,
                ]);
            } else {
                $data['chatdata'] = ChatMessage::create([
                    'chat_favourites_id'=> $request->chat_favourites_id,
                    'sender_type'=>$request->sender_type,
                    'body'=>$request->body,
                ]);
            }
        }
        // $pusher = new Pusher(
        //     env('PUSHER_APP_KEY'),
        //     env('PUSHER_APP_SECRET'),
        //     env('PUSHER_APP_ID'),
        //     [
        //         'cluster' => env('PUSHER_APP_CLUSTER'),
        //         'encrypted' => true,
        //     ]
        // );
        // $pusher->trigger('chat', 'new-message', [
        //     'message' => $data,
        // ]);
        return response()->json($data);
    }
    public function get_ChatMessages(Request $request)
    {
    //    $data['chatfavourite']= ChatFavourite::where('user_id',$request->user_id ,'and','user_deleted',0)->first();
       $data['chat_messages'] = ChatMessage::where('chat_favourites_id', $request->chatfavourite_id)->get();
        return  response($data);
    }
// All message deleted by admin
    public function user_favourite_deleted(Request $id)
{
   $user = ChatFavourite::where('user_id', $id)->first();
    if ($user->user_deleted == 0) {
        ChatFavourite::where('user_id', $id)->update('admin_deleted',1)->first();
    } else {
        ChatFavourite::where('user_id', $id)->delete();
    }
    return redirect()->route('chat.index');
}
// single message deleted
    public function user_message_deleted(Request $id){
        $user = ChatMessage::find('id', $id)->first();
    if ($user->user_deleted == 0) {
        ChatMessage::find('id', $id)->update('admin_deleted',1)->first();
    } else {
        ChatMessage::find('id', $id)->delete();
    }
    return redirect()->route('chat.index');
    }
    //seen message
    public function mark_as_seen($id)
    {
    $user = ChatMessage::where('chat_favourites_id', $id)->first();
    if ($user->seen == 0) {
        ChatMessage::where('chat_favourites_id', $id)->limit(1)->update(['seen' => 1]);
    }
    else
    {
        ChatMessage::where('chat_favourites_id', $id)->limit(1)->update(['seen' => 0]);
    }
    }


}
