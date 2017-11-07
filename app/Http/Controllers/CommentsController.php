<?php

namespace App\Http\Controllers;

use App\Repositories\AnswerRepository;
use App\Repositories\CommentRepository;
use App\Repositories\QuestionRepositories;
use Illuminate\Http\Request;
use Auth;

class CommentsController extends Controller
{
    protected $answer;
    protected $question;
    protected $comment;

    public function __construct(AnswerRepository $answer,QuestionRepositories  $question,CommentRepository $comment)
    {
        $this->answer = $answer;
        $this->question = $question;
        $this->comment = $comment;
    }

    public  function answer($id)
    {
        return $this->answer->getAnswerCommentsById($id);
    }

    public function question($id)
    {
        return $this->question->getQuestionCommentsById($id);
    }

    public function store()
    {
        $model = $this->getModelNameFromType(request('type'));

        $data = [
            'commentable_id' => request('model'),
            'commentable_type' => $model,
            'user_id' => Auth::guard('api')->user()->id,
            'body' => request('body')
        ];

        $comment = $this->comment->create($data);

        return $comment;
    }

    public function getModelNameFromType($type)
    {
        return $type === 'question' ? 'App\Question' : 'App\Answer';
    }
}
