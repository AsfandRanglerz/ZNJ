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
        $data['chatfavourites']= ChatFavourite::where('admin_deleted',0)->with('User')->latest()->get();
        return view('admin.Chat.index',compact('data'));
    }
    public function store(Request $request)
    {
        // return response()->json($request);
        $exists = ChatFavourite::where('user_id', $request->user_id)->exists();
        if (!$exists) {
            $chatfavourite= ChatFavourite::create([
                'user_id' => $request->user_id,
                'admin_id' => 1,
            ]);
            $data['chatfavourite']= $chatfavourite;
            if ($request->hasFile('body')) {
                $filePath = $request->file('body')->store('uploads');

                $data['chatdata'] = ChatMessage::create([
                    'chat_favourites_id'=> $chatfavourite->id ,
                    'sender_type'=>$request->sender_type,
                    'body'=>$filePath,
                ]);
            } else {

                $data['chatdata'] = ChatMessage::create([
                    'chat_favourites_id'=> $chatfavourite->id,
                    'sender_type'=>$request->sender_type,
                    'body'=>$request->body,
                ]);
            }
        }else{
            if ($request->hasFile('body')) {
                $filePath = $request->file('body')->store('uploads');

                $data['chatdata'] = ChatMessage::create([
                    'chat_favourites_id'=> $request->chatfavourites_id ,
                    'sender_type'=>$request->sender_type,
                    'body'=>$filePath,
                ]);
            } else {
        // return response($request->chat_favourites_id);

                $data['chatdata'] = ChatMessage::create([
                    'chat_favourites_id'=> $request->chat_favourites_id ,
                    'sender_type'=>$request->sender_type,
                    'body'=>$request->body,
                ]);

            }
        }

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'encrypted' => true,
            ]
        );
        $pusher->trigger('chat', 'new-message', [
            'message' => $data,
        ]);
        return response($request->body);

    }
    public function get_ChatMessages(Request $request)
    {
       $data['chat_favourite']= ChatFavourite::where('id',$request->chatfavourite_id)->with('User')->first();
       $data['chat_messages'] = ChatMessage::where('chat_favourites_id', $request->chatfavourite_id)->where('admin_deleted',0)->get();
        return  response($data);
    }
// All message deleted by admin

    /** delete the favorite user */
    public function favouriteDeleted(Request $request)
    {
        $user = ChatFavourite::find($request->id);
       // return response()->json($user);
        if ($user->user_deleted == 0) {
            $user->update(['admin_deleted' => 1]);
            //return response()->json($user);
        } else {
            $user->delete();
        }
        return response()->json([
            'success' => 'user deleted successfully',
            'user' => $user,
        ]);
        //return redirect()->route('chat.index');
    }
// single message deleted
    public function MessageDeleted(Request $request)
    {
        $user = ChatMessage::find($request->id);
      // return response()->json($user);
        if ($user->user_deleted == 0) {
            $user->update(['admin_deleted' => 1]);
            //return response()->json($user);
        } else {
            $user->delete();
        }
       // $user = ChatMessage::where('admin_deleted',0)->get();
        return response()->json([
            'success' => 'user deleted successfully',
            'user' => $user,
        ]);
        //return redirect()->route('chat.index');
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
