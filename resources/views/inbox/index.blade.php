@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">私信列表</div>
                    <div class="panel-body">
                     @foreach($messages as  $messageGroup)
                         {{--$key 就是to_user_id 的值，group是根据to_user_id来进行分组的--}}
                            <div class="media {{ $messageGroup->first()->is_read === 'F' ? 'unread': '' }}">
                                <div class="media-left">
                                    {{--根据最新的message的to_user_id来判断显示的头像和内容--}}
                                    @if($messageGroup->first()->to_user_id == Auth::id())
                                        <a href="">
                                            <img width="36" height="36" src="{{ $messageGroup->first()->fromUser->avatar }}"
                                                 alt="">
                                        </a>
                                    @else
                                        <a href="">
                                            <img width="36" height="36" src="{{ $messageGroup->first()->toUser->avatar }}"
                                                 alt="">
                                        </a>
                                    @endif
                                </div>
                                <div class="media-body ">
                                    @if($messageGroup->first()->to_user_id == Auth::id())
                                        <h4 class="media-heading">
                                            <a href="#">
                                                {{ $messageGroup->first()->fromUser->name }}
                                            </a>
                                        </h4>
                                    @else
                                        <h4 class="media-heading">
                                            <a href="#">
                                                {{ $messageGroup->first()->toUser->name }}
                                            </a>
                                        </h4>
                                    @endif
                                    <p>
                                        <a href="/inbox/{{ $messageGroup->first()->dialog_id }}">
                                            {{--last()表示的是最新--}}
                                            {{--这边用first() 是因为我们按照时间对数据进行了排序--}}
                                            {!!  $messageGroup->first()->body !!}
                                        </a>
                                    </p>
                                </div>
                            </div>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection