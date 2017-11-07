<?php

namespace App\Http\Controllers;

use App\Repositories\QuestionRepositories;
use Illuminate\Http\Request;
use Auth;
use App\User;


class QuestionFollowController extends Controller
{
    protected $question;

    public function __construct(QuestionRepositories $question)
    {
        $this->middleware('auth');
        $this->question = $question;
    }

    public function follow($question)
    {

        Auth::user()->followThis($question);

        return back();
    }

    public function follower(Request $request)
    {

        $user = Auth::guard('api')->user();

        /*$folloewd =  \App\Follow::where('question_id',$request->get('question'))
                                  ->where('user_id',$user->id)
                                  ->count();*/
        $folloewd = $user->followed($request->get('question'));
        if ($folloewd){
            return response()->json(['followed'=>true]);
        }else{
            return response()->json(['followed'=>false]);
        }

    }

    public function followThisQuestion(Request $request )
    {
        //之前通过Auth::id()  来获取当前用户的Id值，不能获取到是因为api里面 需要是 有状态的状态下才能获取到Auth::id() 在api里面不能直接
        //获取到session中的值
        $user = Auth::guard('api')->user();

        /*$folloewd =  \App\Follow::where('question_id',$request->get('question'))
            ->where('user_id',$user->id)
            ->first();*/
        // $request->get('question') 就是question_id
        $question =  $this->question->byId($request->get('question'));

        $followed= $user->followThis($question->id);
//    $folloewd = $user->follows()->where('question_id',$question->id)->first();
        if (count($followed['detached']) > 0){
            // 如果该用户已经follow这个问题了，就让其不follow 然后followers_count减一
            $question->decrement('followers_count');
//        $folloewd->delete();
            // 向api返回的值是 followed是false
            return response()->json(['followed'=>false]);
        }

        /*\App\Follow::create([
            'question_id' => $request->get('question'),
            'user_id' => $request->get('user'),
        ]);*/
        // 如果用户没有follow改用户，那就让followwes_count加一
        $question->increment('followers_count');
        // 返回followed的值是true
        return response()->json(['followed'=>true]);
    }
}
