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
                <div class="panel-heading">Pagina verplaatsen</div>

                <div class="panel-body">
                    @include('common.errors')

                    <form class="form-horizontal" role="form" method="post" action="{{ url('/editor/' . $site_id . '/post-move-page') }}">
                        {{ csrf_field() }}

                        <input type="hidden" id="page_id" name="page_id" value="{{ $id }}">
                        <input type="hidden" id="site_id" name="site_id" value="{{ $site_id }}">
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Verplaats <i>{{ $name }}{{ $extension }}</i> naar map:</label>

                            <div class="col-md-3">
                                <select name="parent_id" id="parent_id" class="form-control">
                                    <option value="0">/ </option>
                                    @foreach ($folders as $folder)
                                    <option value="{{ $folder->id }}">{{ $folder->name }}/  </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                     Verplaats
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
