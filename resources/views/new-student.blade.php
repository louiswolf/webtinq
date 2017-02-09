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
                <div class="panel-heading">Leerling account aanmaken</div>

                <div class="panel-body">
                    @include('common.errors')

                    @if (\Session::has('success'))
                        <div class="alert alert-success">{!! \Session::get('success') !!}</div>
                    @endif

                    <form class="form-horizontal" role="form" method="post" action="{{ url('/create-new-student') }}">
                        {{ csrf_field() }}
                        <div class="form-group">

                            <label for="name" class="col-md-4 control-label">Naam</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                     <i class="fa fa-plus"></i> Account maken
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if (count($students) > 0)
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Bestaande Leerlingen</div>

                <div class="panel-body">
                    <div class="col-md-12 col-md-offset-1">
                        <div class="center-block" style="margin: 20px 0">
                            Leerlingen kunnen met onderstaande login en wachtwoord inloggen op <a href="https://webtinq.nl" target="_blank">https://webtinq.nl</a> om hun eigen website te bouwen.
                        </div>
                    </div>

                    <div class="col-md-offset-1">
                        <div class="col-md-4">
                            <label>Leerling</label>
                        </div>
                        <div class="col-md-4">
                            <label>Login</label>
                        </div>
                        <div class="col-md-4">
                            <label>Wachtwoord</label>
                        </div>
                    </div>

                    @foreach($students as $student)
                        <div class="col-md-offset-1">
                            <div class="col-md-4">
                                <span>{{ $student->name }}</span>
                            </div>
                            <div class="col-md-4">
                                <span>{{ $student->email }}</span>
                            </div>
                            <div class="col-md-4">
                                <span>{{ $student->password_unencrypted }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
