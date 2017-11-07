@extends('layouts.app')

@section('content')
    <div  class="row">
        <div class="container">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">个人设置</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="/settings">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">姓名</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ Auth::user()->settings['name'] }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="live" class="col-md-4 control-label">居住地</label>
                                <div class="col-md-6">
                                    <input id="live" type="text" class="form-control" name="live" value="{{ Auth::user()->settings['live'] }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="bio" class="col-md-4 control-label">个人描述</label>
                                <div class="col-md-6">
                                    <textarea id="bio" name="bio" class="form-control" >{{ Auth::user()->settings['bio'] }}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        提交个人设置
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection