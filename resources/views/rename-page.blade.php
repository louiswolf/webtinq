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
                <div class="panel-heading">Pagina hernoemen</div>

                <div class="panel-body">
                    @include('common.errors')

                    <form class="form-horizontal" role="form" method="post" action="{{ url('/post-rename-page') }}">
                        {{ csrf_field() }}

                        <input type="hidden" id="page_id" name="page_id" value="{{ $id }}">
                        <input type="hidden" id="site_id" name="site_id" value="{{ $site_id }}">
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Nieuwe naam</label>

                            <div class="col-md-3">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $name }}">
                            </div>
                            <label class="col-md-1 control-label">
                                <span>{{ $extension }}</span>
                            </label>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn bnt-primary">
                                     <i class="fa fa-plus"></i> Opslaan
                                </button>
                                <a href="{{ url('/editor/'.$site_id.'/page/'.$id) }}" class="btn btn-link">Terug</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
