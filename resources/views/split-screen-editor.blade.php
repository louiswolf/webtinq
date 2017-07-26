@extends('layouts.app')
@section('content')
    <style>
        body {
            margin-bottom: 0;
        }

        .container {
            width: 100vw;
        }

        .navbar {
            margin: 0;
            max-height: 35px !important;
            min-height: 34px !important;
            overflow: hidden;
        }

        .navbar-header a img {
            width: 100px !important;
        }

        .navbar-nav img {
            max-width: 35px !important;
        }

        .navbar-nav > li > a {
            padding: 8px;

        }

        .status-bar {
            height: 25px;
            background: #eee;
            border-top: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
            color: #aaa;
            line-height: 23px;
            font-size: 12px;
        }

        .status {
            float: left;
            padding-left: 18px;
        }

        .buttons {
            text-align: right;
            padding-right: 10px;
            float: right;
        }

        .split-screen-container,
        iframe {
            height: calc(100vh - 90px);
        }

        .split-screen-container {
            display: inline-flex;
            margin: 0;
            padding: 0;
            width: 100%;
            align-items: stretch;
        }

        .split-screen {
            width: 50%;
            overflow: hidden;
        }

        .editor {
            border-right: 1px solid #ccc;
        }

        .preview {
            border-left: 1px solid #ccc;
            overflow: hidden;
        }

        .footer {
            display: inline-block;
            float: left;
            position: relative;
            height: 28px;
        }

        .footer span,
        .footer .social a {
            font-size: 10px !important;
        }

        #editor-iframe {
            border: 0;
            width: 100%;
            height: 100%;
        }

        form {
            line-height: 0;
        }
    </style>
    <form name="form-editor" id="form-editor" style="padding:0;margin:0" class="form-horizontal" role="form" method="post" action="@if ($page){{ url('/editor/'.$id.'/save-page/'.$page->id) }}@endif">
        <div class="status-bar">
            <span id="auto-save-status" class="status"></span>
            <span class="buttons"><a href="{{ $url_close }}"><i class="fa fa-close"></i></a></span></div>
        <div class="split-screen-container">
            {{ csrf_field() }}
            <textarea id="content" name="content"></textarea>
            <div id="editor" name="editor" class="split-screen editor">{{ $page->content }}</div>
            <div class="split-screen preview"><iframe id="editor-iframe" src="{{ $path_preview }}"></iframe></div>
        </div>
    </form>
    <script src="{{ asset('assets/js/jquery/jquery.min.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('assets/js/jscolor/jscolor.min.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('assets/js/ace/ace.js') }}" type="text/javascript" charset="utf-8"></script>
    <script>
        var form = $('#form-editor');
        var textarea = $('#content');
        textarea.hide();
        var editor = ace.edit("editor");
        var interval = new Array(0);

        function autoSave() {
            var auto_save_content = editor.getSession().getValue();
            if (interval != null) {
                $('#auto-save-status').html('Automatisch opslaan..');
                $.ajax({
                    url: "{{ url('/auto-save/'.$id.'/'.$page->id) }}",
                    context: document.body,
                    data: {auto_save_content: auto_save_content}
                }).done(function (data) {
                    while(interval.length > 0) {
                        window.clearInterval(interval.pop());
                    }
                    $('#auto-save-status').html('');
                    document.getElementById('editor-iframe').setAttribute('src', document.getElementById('editor-iframe').getAttribute('src'));
                });
            }
        }

        if ( editor ) {
            editor.setTheme("ace/theme/monokai");
            editor.setOption("showPrintMargin", false);

            textarea.val( editor.getSession().getValue() );

            @if ($extension == '.html')
                editor.getSession().setMode("ace/mode/html");
            @endif
            @if ($extension == '.css')
                editor.getSession().setMode("ace/mode/css");
            @endif
            @if ($extension == '.js')
                editor.getSession().setMode("ace/mode/javascript");
            @endif

            editor.getSession().on('change', function(e) {
                interval.push(window.setInterval(autoSave, 1000));
            });

            form.submit( function( event ) {
                textarea.val( editor.getSession().getValue() );
            });
        }
    </script>
@endsection
