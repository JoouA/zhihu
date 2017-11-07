<?php
/**
 * Created by PhpStorm.
 * User: 24922
 * Date: 2017/6/22
 * Time: 11:42
 */

namespace App\Repositories;
use App\Answer;

class AnswerRepository
{
    public function create(array $data){
        return  Answer::create($data);
    }

    public function answerQuestionid_user_id(){
         return Answer::with('question','user');
    }

    public function byId($id){
        return Answer::find($id);
    }

    public function getAnswerCommentsById($id){
        $answer = Answer::with('comments','comments.user')->where('id',$id)->first();

        return $answer->comments;

    }

}