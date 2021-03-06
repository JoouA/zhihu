@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">对话列表</div>
                    <div class="panel-body">
                        <form action="/inbox/{{$dialogId}}/store" method="post">
                            {{ csrf_field()  }}
                            <div class="form-group">
                                <textarea  name="body" class="form-control"></textarea>
                            </div>
                            <div class="form-group pull-right">
                                <button class="btn btn-success">发送私信</button>
                            </div>
                        </form>
                        <div style="margin-top: 80px">
                            @foreach($messages as  $message)
                                <div class="media">
                                    <div class="media-left">
                                        <a href="">
                                            <img width="36" height="36" src="{{ $message->fromUser->avatar }}">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <h4 class="media-heading">
                                            <a href="#">
                                                {{ $message->fromUser->name }}
                                            </a>
                                            <span class="pull-right">
                                                @if($message->is_read === 'T')
                                                    <font style="color: #2ab27b"><strong>以读</strong></font>
                                                @else
                                                    <font color="red">未读</font>
                                                @endif
                                            </span>

                                        </h4>
                                        <p>
                                            {!!  $message->body !!} <span class="pull-right"> {{$message->created_at->format('Y年m月d日 H时:i分')}}</span>
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection