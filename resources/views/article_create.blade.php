@extends('layouts.app')
@section('content')
    <div align="center">
        <form action="/article" method="POST">
            {{ csrf_field()  }}
            <div class="form-group">
                <label for="title">Title</label>
                <input id="title" type="text"  name="title" value="{{ old('title') }}">
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea id="content" name="content">{{ old('content') }}</textarea>
            </div>
            <div class="form-group">
                <label for="taglist">TagList</label>
                <select name="tags[]" id="taglist" class="js-example-basic-multiple form-control" multiple="multiple">
                    @foreach($tags as $tag)
                         <option  value="{{ $tag->id }}">{{ $tag->title }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success">提交</button>
        </form>
    </div>
@section('js')
    <script type="text/javascript">
        $(".js-example-basic-multiple").select2();
    </script>
@endsection
@endsection