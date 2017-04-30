@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1" style="text-align: right;">
            <ul style="list-style: none;">
                <li style="display:inline-block;margin-left:10px">
                    <a href="{{ url('/dashboard') }}">Dashboard</a>
                </li>
                <li style="display:inline-block;margin-left:10px">
                    <a href="{{ url('/settings') }}">Jouw Instellingen</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Klasportalen beheren</div>

                <div class="panel-body">
                    @include('common.errors')

                    <form class="form-horizontal" role="form" method="post" action="{{ url('/create-new-student') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            @foreach ( $user->portals as $portal )
                                <div class="col-md-10 col-md-offset-1">
                                        <div class="col-md-2">
                                            {{--<input type="checkbox">--}}
                                        </div>
                                        <div class="col-md-2">
                                            <span class="">{{ $portal->name }}</span>
                                        </div>
                                        <div class="col-md-6">
                                            {{--<a href="">Bewerk (TODO)</a> / <a href="">Open (TODO)</a> / <a href="">Sluit (TODO)</a>--}}
                                        </div>
                                        <div class="col-md-2">
                                            <a href="{{ url('portal/' . $portal->id ) }}">Bekijk</a>
                                        </div>
                                </div>
                            @endforeach
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
