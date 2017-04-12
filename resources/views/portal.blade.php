@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $portal->name }}</div>

                <div class="panel-body">
                    @foreach ($portal->students as $student)
                        <div class="" style="background: #f5f5f5;padding:5px;border-radius:3px;margin-bottom: 5px;position:relative;">
                            <div class="avatar-name" style="width:100px;display:inline-block;text-align: center;">
                                @if ( $student->avatar )
                                    <img src="/webtinq/storage/app/{{ $student->avatar->location }}" style="max-height:75px;max-width:75px;"><br>
                                @else
                                    <img src="" style="width:75px;height:75px;border:1px solid #000;"><br>
                                @endif
                                {{ $student->name }}
                            </div>
                            <div class="site-list" style="display: inline-block;position:relative;top:-25px;">
                                @if ( count( $student->sites ) )
                                    <ul style="list-style-type: none;">
                                    @foreach( $student->sites as $site )
                                        @if ( $site->published && !$site->deleted )
                                            <li style="display:inline-block;"><a class="btn btn-default" href="{{ url( $site->slug . '/index.html' ) }}">{{ $site->name }}</a></li>
                                        @endif
                                    @endforeach
                                    </ul>
                                @else
                                    <span>Geen websites gevonden</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection