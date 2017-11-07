<?php

namespace App\Http\Controllers;

use App\Http\Requests\questionsRulesRequest;
use App\Question;
use App\Repositories\QuestionRepositories;
use App\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionsController extends Controller
{
    protected $questionRepository;

    public function __construct(QuestionRepositories $questionRepositories )
    {
        $this->middleware('auth')->except('index','show');
        $this->questionRepository = $questionRepositories;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions  = $this->questionRepository->getQuestionsFeed();
        return view('questions.index',compact('questions'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('questions.make');
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\questionsRulesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
         //重学表单的验证方法 让其代码在里分离出来 使用request方法来限定
         $rules  = [
            'title' => 'required|min:6|max:191',
            'body' => 'required|min:5'
        ];

        $message =  [
            'title.required'  => '标题sssss空 ',
            'title.min' =>  '标题不能少于6个字符',
            'title.max' => '标题不能超过191个字符',
            'body.required' => '内容是必须的',
            'body.min' => '内容不能过断'
        ];

        $this->validate($request,$rules,$message);
          

//        dd($request->get('topics'));

        $topics = $this->questionRepository->normalizeTopic($request->get('topics'));
        $data = [
            'title' => $request->get('title'),
            'body' => $request->get('body'),
            'user_id' => Auth::id(),
        ];

//        $question =  Question::create($data);

        // 上面的create方法写到QuestionRepositories中了
        $question = $this->questionRepository->create($data);

        // 这个操作是 将数据写入到question_topic这个表中去了
        $question->topics()->attach($topics);

        return redirect()->route('questions.show',$question->id);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$question = Question::where('id',$id)->with('topics')->first();

        // 获得question的数据
        $question = $this->questionRepository->byIdWithTopicsAnswers($id);
//        dd($question);
        if (is_null($question)){
            return redirect()->back();
//            return view('questions.403');
        }
//        dd($question);
        //return view('questions.show', ['question' => $question,'answers' => $answers]);
        return view('questions.show', compact('question'));

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
//        $question = Question::find($id);
        $question = $this->questionRepository->byId($id);
        if (Auth::user()->owns($question)){
            return view('questions.edit',compact('question'));
        }
        return back();

    }



    public function update(questionsRulesRequest $request, $id)
    {
        $question = $this->questionRepository->byId($id);
        $topics = $this->questionRepository->normalizeTopic($request->get('topics'));

        $data = [
            'title' => $request->get('title'),
            'body' => $request->get('body'),
        ];

        $question->update($data);

        // 同步更新question里面的topic
        $question->topics()->sync($topics);

        flash('更新成功')->success()->important();
        return redirect()->route('questions.show',$id);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = $this->questionRepository->byId($id);
        if (Auth::user()->owns($question)){
            $question->delete();

            return redirect('/');
        }

        return view('questions.403');

    }

}
