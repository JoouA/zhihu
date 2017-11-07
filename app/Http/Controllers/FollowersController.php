<?php

namespace App\Http\Controllers;

use App\Notifications\NewUserFollowNotification;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Auth;


class FollowersController extends Controller
{
    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function index($id){
        // $user 是创建这个问题的人
        $user = $this->user->byId($id);

        //在表中获得关注这个人的追随者的id
//        $followers = $user->followers()->pluck('follower_id')->toArray();  // 这样获取的值是空的
        $followers = $user->followersUser()->pluck('follower_id')->toArray();

        // 判断当前登陆的用户id，是不是关注的人的id一致   如果一致返回true 否则 返回false
        if (in_array(Auth::guard('api')->user()->id,$followers)){
            return response()->json(['followed' => true]);
        }
        return response()->json(['followed' => false]);
    }

    public function follow(){
        // $userToFollow  创建问题的人
        $userToFollow = $this->user->byId(request('user'));

        $followed = Auth::guard('api')->user()->followThisUser($userToFollow->id);
        if (count($followed['attached']) > 0){

            $userToFollow->notify(new NewUserFollowNotification());

            $userToFollow->increment('followers_count');
            return response()->json(['followed' => true]);
        }

        $userToFollow->decrement('followers_count');
        return response()->json(['followed' => false]);
    }
}
