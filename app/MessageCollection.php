<?php
/**
 * Created by PhpStorm.
 * User: 24922
 * Date: 2017/7/13
 * Time: 15:07
 */

namespace App;

use Auth;

use Illuminate\Database\Eloquent\Collection;

class MessageCollection extends Collection
{
    public function markAsRead()
    {
        $this->each(function ($message){

            if ($message->to_user_id === Auth::id())
            {
                $message->markAsRead();
            }
        });
    }
}