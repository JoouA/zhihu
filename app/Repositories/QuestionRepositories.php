<?php
/**
 * Created by PhpStorm.
 * User: 24922
 * Date: 2017/6/19
 * Time: 22:16
 */

namespace App\Repositories;
use App\Question;
use App\Topic;
use App\Answer;

class QuestionRepositories
{
    public function byIdWithTopicsAnswers($id){
       return Question::where('id','=',$id)->with(['topics','answers'])->first();
    }

    public function create(array $attributes){
         return  Question::create($attributes);
    }

    public function normalizeTopic(array $topics){
        // 使用collect（）->map() 来判断 传入的$topic中是否有数字 如果是文字将其存储然后将ID取出来
        return collect($topics)->map(function ($topic){
            if (is_numeric($topic)){
                // 当选择已经存在标签的时候 就更新其questions_count
                Topic::find($topic)->increment('questions_count');
                return (int)$topic;
            }
            // 当标签不存在的时候 就在数据库里面创建新的标签信息 然后将其id返回
            $newTopic = Topic::create(['name'=>$topic,'questions_count' => 1]);
            return $newTopic->id;
        })->toArray();
    }

    public function byId($id){
        return Question::find($id);
    }

    public function getQuestionsFeed(){
        // 使用scopePublished（）这个方法的时候前面的scope就不需要了 不要管为什么这么做 反正laravel就是这样定义的
        return Question::Published()->latest('updated_at')->with('user')->get();
    }

    public function getQuestionCommentsById($id){
        $question = Question::with('comments','comments.user')->where('id',$id)->first();
        return $question->comments;
    }

}