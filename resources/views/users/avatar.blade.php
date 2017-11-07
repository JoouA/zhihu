@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 col-lg-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">修改头像</div>
                <div class="panel-body">
                    <user-avatar avatar="{{ Auth::user()->avatar }}" csrf_tk="{{ csrf_token() }}"></user-avatar>
                </div>
            </div>
        </div>
    </div>

@endsection