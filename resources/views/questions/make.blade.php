@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">发布问题</div>
                    <div class="panel-body">
                        <form action="/questions" method="post">
                            {{csrf_field()}}
                            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                <label for="title">标题</label>
                                <input type="text" name="title" class="form-control" placeholder="标题"  id="title" value="{{ old('title') }}">
                                @if ($errors->has('title'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <select name="topics[]" class="js-data-example-ajax form-control" multiple="multiple" required>
                                </select>
                            </div>
                            <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                                <label for="container">内容</label>
                                <textarea id="container" name="body" type="text/plain">{!! old('body') !!}</textarea>
                                @if ($errors->has('body'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <button type="submit"  class="btn btn-success pull-right">发布问题</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('vendor.ueditor.assets')
@section('js')
    <script type="text/javascript">
        var ue = UE.getEditor('container');
        ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
        $(document).ready(function () {
            function formatTopic (topic) {

                return "<div class='select2-result-repository clearfix'>" +

                "<div class='select2-result-repository__meta'>" +

                "<div class='select2-result-repository__title'>" +

                topic.name ? topic.name : "Laravel"   +

                    "</div></div></div>";

            }


            function formatTopicSelection (topic) {

                return topic.name || topic.text;

            }


            $(".js-data-example-ajax").select2({

                tags: true,

                placeholder: '选择相关话题',

                minimumInputLength: 2,

                ajax: {

                    url: '/api/topics',

                    dataType: 'json',

                    delay: 250,

                    data: function (params) {

                        return {

                            q: params.term

                        };

                    },

                    processResults: function (data, params) {

                        return {

                            results: data

                        };

                    },

                    cache: true

                },

                templateResult: formatTopic,

                templateSelection: formatTopicSelection,

                escapeMarkup: function (markup) { return markup; }

            });
        });
    </script>
@endsection






