@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row">
        <div class="col-md-12" style="text-align: right;">
            <ul style="list-style: none;">
                <li style="display:inline-block;margin-left:10px">
                    <a href="{{ url('/dashboard') }}">Dashboard</a>
                </li>
                <li style="display:inline-block;margin-left:10px">
                    <a class="active" href="{{ url('/settings') }}">Jouw Instellingen</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Instellingen van {{ $user->name }}</div>

                <div class="panel-body">
                    @include('common.errors')

                    @if (\Session::has('warning'))
                        <div class="alert alert-warning">{!! \Session::get('warning') !!}</div>
                    @endif

                    @if (\Session::has('success'))
                        <div class="alert alert-success">{!! \Session::get('success') !!}</div>
                    @endif

                    <form class="form-horizontal" role="form" method="post" action="{{ url('/save-settings') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <input type="hidden" id="user_id" name="user_id" value="{{ $user->id }}">

                        <div class="form-group">
                            <label for="avatar" class="col-md-4 control-label">Avatar</label>
                            <div class="col-md-6">
                                <span class="btn btn-default btn-file"><input type="file" accept="bmp,.gif,.jpg,.jpeg,.png" value="{{ old('avatar') }}" name="avatar" id="avatar"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password1" class="col-md-4 control-label">Wachtwoord</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" value="{{ old('password1') }}" name="password1" id="password1">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password2" class="col-md-4 control-label">Herhaling wachtwoord</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" value="{{ old('password2') }}" name="password2" id="password2">
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">Bewaar instellingen</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
