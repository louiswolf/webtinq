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
                <div class="panel-heading">Open klasportaal</div>

                <div class="panel-body">
                    @include('common.errors')

                    <form class="form-horizontal" role="form" method="post" action="{{ url('/post-create-portal') }}">
                        {{ csrf_field() }}

                        @if ( $students )
                            <div class="form-group">

                                <label for="name" class="col-md-4 control-label">Klasportaal naam</label>

                                <div class="col-md-6">
                                    <input id="portal_name" type="text" class="form-control" name="portal_name" value="{{ old('portal_name') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                    <label for="student[]" class="col-md-4 control-label">Leerlingen</label>
                                    @foreach( $students as $student )
                                        <div class="col-md-6 col-md-offset-4">
                                            {{ $student->name }} <input type="hidden" name="student[]" value="{{ $student->id }}">
                                        </div>
                                    @endforeach
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn bnt-primary">
                                         <i class="fa fa-plus"></i> Open klasportaal
                                    </button>
                                </div>
                            </div>
                        @else

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    Er zijn geen leerlingen geselecteerd
                                </div>
                            </div>

                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
