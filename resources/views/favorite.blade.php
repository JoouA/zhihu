@extends('layouts.app')

@section('content')
    <div class="row">
        @foreach($favorites as $favorite)
        <article class="col-md-6">
            <h1>{{ $favorite->title }}</h1>
            <img  src="{{$favorite-> imgUrl}}" width="100%" alt="">
            <span>{{ $favorite->content }}</span>
        </article>
        @endforeach
    </div>
    <div class="pull-right">
        {{ $favorites->links() }}
    </div>
@endsection