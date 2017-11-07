<?php

namespace App\Http\Controllers;

use App\Notifications\NewMessageNotification;
use App\Repositories\MessageRepository;
use Illuminate\Http\Request;
use App\Message;
use Auth;

class InboxController extends Controller
{

    protected $message;

    /**
     * InboxController constructor.
     */
    public function __construct(MessageRepository $message)
    {
        $this->message = $message;
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $messages = $this->message->getMessagesByToUserIdAndFromUserId();

        return view('inbox.index',compact('messages'));
    }

    /**
     * @param $dialogId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($dialogId)
    {
        $messages= $this->message->getMessagesByDialogId($dialogId);

        /*
         // 方法一：直接foreach出对象然后执行markAsRead
         foreach ($messages as $message)
        {
            if ($message->to_user_id === Auth::id())
            {
                $message->markAsRead();
            }
        }*/

        $messages->markAsRead();


        return view('inbox.show',compact('messages','dialogId'));
    }


    /**
     * @param $dialogId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($dialogId)
    {

        $newMessage = $this->message->storeMessageByDialogId($dialogId);

        $newMessage->toUser->notify(new NewMessageNotification($newMessage));

        return back();
    }

}
