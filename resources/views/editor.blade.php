@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12" style="text-align: right;">
            <ul style="list-style: none;">
                <li style="display:inline-block;margin-left:10px">
                    <a href="{{ url('site-settings/' . $id) }}">Site instellingen</a>
                </li>
                 <li style="display:inline-block;margin-left:10px">
                    <a href="{{ url('/dashboard') }}">Dashboard</a>
                </li>
                <li style="display:inline-block;margin-left:10px">
                    <a href="{{ url('/settings') }}">Jouw instellingen</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                    <div class="panel-heading">
                        Editor
                        @if (!$file) <a style="float:right;" href="{{ $url_request }}/split"><i class="fa fa-columns"></i></a> @endif
                    </div>
                    <div class="panel-body">
                    @include('common.errors')

                        <form name="form-editor" id="form-editor" class="form-horizontal" role="form" method="post" action="@if ($page){{ url('/editor/'.$id.'/save-page/'.$page->id) }}@endif">
                            {{ csrf_field() }}
                            <textarea id="content" name="content"></textarea>

                            @if ($page)
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label for="content" class="form-label">{{ $page->name }}{{ $extension }}</label>
                                    <span> | </span>
                                    @if ($extension == '/')
                                        {{ $path }}
                                    @else
                                        <a href="{{ $path }}" target="_blank">{{ $path }}</a>
                                    @endif
                                </div>
                            </div>
                            @endif

                            @if ($file)
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label for="content" class="form-label">{{ $file->name }}</label>
                                    <span> | </span>
                                    <a href="{{ $path }}" target="_blank">{{ $path }}</a>
                                </div>
                            </div>
                            @endif

                            <div class="form-group">

                                @if ($page && $extension == '.html')
                                    <div class="col-md-9">
                                        <label>HTML</label> <span style="color:#999;">&lt;body&gt;...&lt;/body&gt;</span>
                                        <pre>&lt;a href="{{$path}}"&gt;link&lt;/a&gt;</pre>
                                    </div>
                                @endif

                                @if ($page && $extension == '.css')
                                    <div class="col-md-9">
                                        <label>HTML</label> <span style="color:#999;">&lt;head&gt;...&lt;/head&gt;</span>
                                        <pre>&lt;link rel="stylesheet" type="text/css" href="{{$path }}"&gt;</pre>
                                    </div>
                                @endif

                                @if ($page && $extension == '.js')
                                    <div class="col-md-9">
                                        <label>HTML</label> <span style="color:#999;">&lt;head&gt;...&lt;/head&gt;</span>
                                        <pre>&lt;script type="text/javascript" src="{{$path}}"&gt;&lt;/script></pre>
                                    </div>
                                @endif

                                <div class="col-md-12">
                                    @if ($page && $extension != '/')
                                            <a href="{{ url( $url_view ) }}" target="_blank">Bekijk</a>
                                        @endif

                                        @if ($file)
                                                <a href="{{ $path }}" target="_blank">Bekijk</a>
                                            @endif

                                        @if ($page && $page->name != 'index' )
                                            @if ($extension != '/')
                                                    <span> | </span>
                                            @endif
                                            @if ($page->name != 'css' && $page->name != 'js')
                                                <a href="{{ url('editor/'.$id.'/rename-page/'.$page->id) }}">Hernoem</a>
                                            @endif
                                            @if ($extension != '/')
                                                    <span> | </span>
                                                    <a href="{{ url('editor/'.$id.'/move-page/'.$page->id) }}">Verplaats</a>
                                                @endif
                                                @if ($page->name != 'css' && $page->name != 'js')
                                                <span> | </span>
                                                    <a href="{{ url('editor/'.$id.'/delete-page/'.$page->id) }}">Verwijder</a>
                                                @endif
                                        @endif

                                        <span id="auto-save-status" class="status-light"></span>
                                    </div>
                            </div>

                            <div class="form-group">
                            @if ($page)
                                    <div class="col-md-9" style="height:400px;position:relative;">
                                    @if ($extension != '/')
                                        <div id="editor" name="editor" class="col-md-9 form-control" style="height: 100%;">{{ $page->content }}</div>
                                    @else
                                        <span>Dit is een map, geen bestand</span>
                                    @endif
                                    </div>
                                @endif

                                @if ($file)
                                    <div class="col-md-9">
                                        <label>HTML</label> <span style="color:#999;">&lt;body&gt;...&lt;/body&gt;</span>
                                        <pre>&lt;img src="{{ $path }}"&gt;</pre>
                                    </div>
                                    <div class="col-md-9">
                                        <label>CSS</label>
                                        <pre>background-image: url('{{ $path }}');</pre>
                                    </div>
                                    <div class="col-md-9">
                                        <a href="{{ $path }}" target="_blank"><img src="{{ $path }}" style="max-width:100%;"></a>
                                    </div>
                                @endif

                                {{-- Sidebar (page tree) --}}
                                @if ($pages == '')
                                    <div class="col-md-offset-9">Geen pagina's gevonden</div>
                                @else
                                    <div class="col-md-offset-9">
                                        <ul style="list-style: none">
                                        {!! $pages !!}
                                        </ul>
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <div class="col-md-7">
                                    @if ($page && $extension != '/')
                                    <button class="btn btn-primary btn-submit"><i class="fa fa-save"></i> Opslaan</button>
                                    @endif
                                    <a href="{{ url('editor/'.$id.'/new-page') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Nieuwe pagina of map</a>
                                    <a href="{{ url('editor/'.$id.'/new-image') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Nieuwe afbeelding</a>
                                </div>
                                <div class="col-md-5">
                                    <input type="button" class="btn btn-default jscolor {valueElement:'color-value',styleElement:'color-background',value:'ff6699'}" value="Kleur">
                                    <span id="color-background" class="form-control" style="display:inline-block;width:90px;">#<span id="color-value">FFFFFF</span></span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/jquery/jquery.min.js') }}" type="text/javascript" charset="utf-8"></script>
<script src="{{ asset('assets/js/jscolor/jscolor.min.js') }}" type="text/javascript" charset="utf-8"></script>
<script src="{{ asset('assets/js/ace/ace.js') }}" type="text/javascript" charset="utf-8"></script>

<script>
    var form = $('#form-editor');

    var textarea = $('#content');
    textarea.hide();

    var editor = ace.edit("editor");
    var interval = new Array(0);


    @if ( !$file )
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
                });
            }
        }
    @endif

    if ( editor ) {
        editor.setTheme("ace/theme/sqlserver");
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

        @if ( !$file )
            editor.getSession().on('change', function(e) {
                interval.push(window.setInterval(autoSave, 3000));
            });

            form.submit( function( event ) {
                textarea.val( editor.getSession().getValue() );
            });
        @endif
    }
</script>
@endsection
