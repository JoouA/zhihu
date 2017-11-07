<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnswerRequest;
use Illuminate\Http\Request;
use Auth;
use App\Repositories\AnswerRepository;

class AnswersController extends Controller
{
    protected $answer;

    public function __construct(AnswerRepository $answer)
    {
        $this->answer = $answer;
    }

    public function store(StoreAnswerRequest $request,$question){
        // $question 就是传过来的question的id号
        $data = [
            'body' =>$request->body,
            'user_id' => Auth::id(),
            'question_id' => $question,
        ];
        $answer = $this->answer->create($data);

        $answer->question()->increment('answers_count');
        Auth::user()->increment('answers_count');
        return back();
    }
}
