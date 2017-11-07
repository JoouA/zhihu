@extends('layouts.app')
@section('content')
    <div align="center">
        <form action="/article/{{ $article->id }}" method="post">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            <div class="form-group">
                <label for="title">Title</label>
                <input id="title" type="text"  name="title" value="{{ $article->title }}">
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea id="content" name="content">{{ $article->content }}</textarea>
            </div>
            <div class="form-group">
                <label for="taglist">TagList</label>
                <select name="tags[]" id="taglist" class="js-example-basic-multiple form-control" multiple="multiple">
                    @foreach($tags as $tag)
                        @if(in_array($tag->id,$seltags))
                            <option  value="{{ $tag->id }}" selected>{{ $tag->title }}</option>
                        @else
                            <option  value="{{ $tag->id }}">{{ $tag->title }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <button class="btn btn-success">提交</button>
            </div>
        </form>
    </div>
@section('js')
    <script type="text/javascript">
        $(".js-example-basic-multiple").select2();
    </script>
@endsection
@endsection