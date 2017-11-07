@extends('layouts.app')

@section('content')
    <div class="row">
        @foreach($articles as $article)
            <article class="col-md-4">
                <h4>{{ $article->title }}</h4>
                <div class="body">
                    <form action="">
                        {{$article->content}}
                        <br>
                        <div class="pull-right">
                            <button class="btn btn-success">编辑</button>
                        </div>
                    </form>
                </div>
            </article>
        @endforeach
    </div>
    <div>
        {{ $articles->links() }}
    </div>
@endsection()


