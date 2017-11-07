<?php
/**
 * Created by PhpStorm.
 * User: 24922
 * Date: 2017/7/8
 * Time: 17:27
 */

namespace App\Repositories;


use App\Message;
use Auth;

class MessageRepository
{
    public function create(array $arrtibutes){

        return Message::create($arrtibutes);
    }

    /**
     * @return mixed
     */
    public function getMessagesByToUserIdAndFromUserId()
    {
        //$messages = Message::where('to_user_id',Auth::id())->with('fromUser')->get();

        //$messages 是二维数组
        //$messages = Auth::user()->messages->groupBy('from_user_id');

        /*
        * 保护数据 with('fromUser') <==> function($query){
        *       return $query->select(['id','name','avatar']);     // 这样做的好处是可以防止其它数据的泄露
         *      }
        *
        **/

        /*Message::where('to_user_id',Auth::id())
            ->orWhere('from_user_id',Auth::id())->latest()->get()->groupBy('dialog_id');*/
        return Message::where('from_user_id',Auth::id())->orWhere('to_user_id',Auth::id())
            ->latest()->get()->groupBy('dialog_id');
    }

    /**
     * @param $dialogId
     * @return mixed
     */
    public function getMessagesByDialogId($dialogId)
    {
        return Message::where('dialog_id',$dialogId)->latest()->get();
    }

    public function storeMessageByDialogId($dialogId)
    {

        //$message = Message::where('dialog_id',$dialogId)->get(); // get()获得的是一个item的数组
        $message = Message::where('dialog_id',$dialogId)->first();

        $toUserId = $message->from_user_id === Auth::id()? $message->to_user_id : $message->from_user_id;

        $data = [
            'from_user_id' => Auth::id(),
            'to_user_id' => $toUserId,
            'body' => request('body'),
            'dialog_id' => $dialogId,
        ];
        return  Message::create($data);
    }
}