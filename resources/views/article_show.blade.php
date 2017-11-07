@extends('layouts.app')
@section('content')
    <div align="center">
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
                    @foreach($article->tags as $tag)
                        <option  value="{{ $tag->id }}" selected="{{ $tag->id }}">{{ $tag->title }}</option>
                    @endforeach
                </select>
            </div>
    </div>
@section('js')
    <script type="text/javascript">
        $(".js-example-basic-multiple").select2();
    </script>
@endsection
@endsection