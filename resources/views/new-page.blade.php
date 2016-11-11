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
                    <a href="{{ url('/settings') }}">Instellingen</a>
                </li>            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Pagina aanmaken</div>

                <div class="panel-body">
                    @include('common.errors')

                    <form class="form-horizontal" role="form" method="post" action="{{ url('/post-new-page') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="site_id" id="site_id" value="{{ $id }}">
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Pagina naam</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="index">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Extensie</label>

                            <div class="col-md-6">
                                <select id="extension" type="text" class="form-control" name="extension">
                                    @foreach( $pagetypes as $pagetype )
                                        <option value="{{ $pagetype->id }}">@if ( $pagetype->name != '/' ).@endif{{ $pagetype->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn bnt-primary">
                                     <i class="fa fa-plus"></i> Pagina maken
                                </button>
                                <a href="{{ url('/editor/'.$id) }}" class="btn btn-link">Terug</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
