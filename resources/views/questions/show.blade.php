@extends('layouts.app')

@section('content')
    @include('vendor.ueditor.assets')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{$question->title}}
                    @foreach($question->topics as $topic)
                            <a class="topic pull-right" href="/topic/{{$topic->id}}">{{$topic->name}}</a>
                    @endforeach
                    </div>
                    <div class="panel-body">
                       {!! $question->body   !!}
                    </div>
                    <div class="actions">
                        @if(Auth::check() && Auth::user()->owns($question))
                            <span class="edit"><a href="/questions/{{$question->id}}/edit">编辑</a></span>
                            <form action="/questions/{{ $question->id}}" method="POST" class="delete-form">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button class="button delete-button">删除</button>
                            </form>
                        @endif
                        <comments type="question"
                                  model="{{$question->id}}"
                                  count="{{$question->comments()->count()}}">

                        </comments>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default ">
                    <div class="panel-heading" align="center">
                        {{--<h2>{{ \App\Follow::where('question_id',$question->id)->count() }}</h2>--}}
                        <h2>{{ $question->followers_count }}</h2>
                        <span>关注者</span>
                    </div>
                    <div class="panel-body">
                      {{--  @if(Auth::check())
                            <a href="/question/{{$question->id}}/follow" class="btn btn-default
                              {{ Auth::user()->followed($question->id)?'btn-success':'' }}">
                                {{ Auth::user()->followed($question->id)?'已关注':'关注该问题' }}
                            </a>
                        @else
                            <a href="/login" class="btn btn-default">
                                关注该问题
                            </a>
                        @endif--}}
                        <question-follow-button question="{{$question->id }}" ></question-follow-button>
                        <a href="#editor"class="btn btn-primary pull-right">
                            撰写答案
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default ">
                    <div class="panel-heading" align="center">
                        <h5>关于作者</h5>
                    </div>
                    <div class="panel-body">
                        <div class="media">
                            <div class="media-left">
                                <a href="#">
                                    <img style="width: 30px;height: 30px" src="{{$question->user->avatar}}" alt="{{ $question->user->name }}">
                                </a>
                            </div>
                            <div class="media-right">
                                <h4 class="media-heading">
                                    <a href="/user_questions/show/{{$question->user->id}}">{{  $question->user->name }}</a>
                                </h4>
                            </div>
                            <div class="user-statics">
                                <div class="statics-item text-center">
                                    <div class="statics-text">问题</div>
                                    <div class="statics-count">{{ $question->user->questions_count }}</div>
                                </div>
                                <div class="statics-item text-center">
                                    <div class="statics-text">回答</div>
                                    <div class="statics-count">{{ $question->user->answers_count }}</div>
                                </div>
                                <div class="statics-item text-center">
                                    <div class="statics-text">关注者</div>
                                    <div class="statics-count">{{ $question->user->followers_count }}</div>
                                </div>
                            </div>
                        </div>
                       <p></p>
                        <user-follow-button user="{{$question->user->id }}" ></user-follow-button>
                        {{--<a href="#editor"class="btn btn-default pull-right">发送私信</a>--}}
                        <send-message user="{{ $question->user_id }}" login_user=" {{ Auth::check()?'T':'F' }} "></send-message>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ $question->answers_count }}个答案
                    </div>
                    @foreach($question->answers as $answer)
                        {{--{{ dd($question) }}--}}
                        <div class="media">
                            <div class="media-left">
                                <a href="">
                                    <img width="36" height="36" src="{{ $answer->user->avatar }}"
                                    alt="{{ $answer->user->name }}">
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">
                                    <a href="/user_questions/show/{{ $answer->user->id }}">
                                        {{ $answer->user->name }}
                                    </a>
                                       {!!  $answer->body !!}

                                    <comments type="answer"
                                              model="{{$answer->id}}"
                                              count="{{$answer->comments()->count()}}">

                                    </comments>

                                    <div>
                                        <span class="pull-left">{{ date('Y年m月d日 H:m',strtotime($answer->created_at))}}</span>
                                        <user-vote-button class="pull-right" answer="{{ $answer->id }}" count="{{ $answer->votes_count }}">
                                        </user-vote-button>
                                    </div>
                                </h4>

                            </div>
                        </div>
                    @endforeach
                    @if(Auth::check())
                    <div class="panel-body" >
                        <form action="/questions/{{ $question->id }}/answer" method="post">
                            {{csrf_field()}}
                            <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                                <label for="container">内容</label>
                                <script id="container" name="body" type="text/plain">{!! old('body') !!}</script>
                                @if ($errors->has('body'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <button type="submit"  class="btn btn-success pull-right">回复问题</button>
                        </form>
                    </div>
                    @else
                        <a href="{{url('login')}}" class="btn btn-success btn-block">
                            登录提交答案
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        var ue = UE.getEditor('container');
        ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
    </script>
@endsection
