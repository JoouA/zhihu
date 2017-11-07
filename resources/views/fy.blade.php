@extends('layouts.app')

@section('content')

    @foreach($pics->chunk(3) as $data)
        <div class="row">
            @foreach($data as $pic)
                <article class="col-md-4">
                    <h4>{{ $pic->title }}</h4>
                    <img src="{{ $pic->imgUrl}}" width="100%">
                    <div class="body">
                        <form action="/favorite" method="POST">
                            {{ csrf_field() }}
                            <button type="submit" >
                                <i class="fa fa-heart {{ in_array($pic->id,$favorites)? 'favorited' : 'not-favorited' }}">
                                </i></button>
                            <input type="hidden" name="pic_id" value="{{ $pic->id }}">
                            {{$pic->content}}
                        </form>
                    </div>
                </article>
            @endforeach
        </div>
    @endforeach

    <div class="pull-right">
        {{ $pics->links() }}
    </div>

@endsection