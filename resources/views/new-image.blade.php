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
                <div class="panel-heading">Nieuwe afbeelding</div>

                <div class="panel-body">
                    @include('common.errors')

                    <form class="form-horizontal" role="form" method="post" action="{{ url('/post-new-image') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="site_id" id="site_id" value="{{ $id }}">
                        <div class="form-group">
                            <label for="parent_folder" class="col-md-4 control-label">Map</label>
                            <div class="col-md-6">
                                <select id="parent_folder" name="parent_folder" class="form-control">
                                    <option value="0">/</option>
                                    @foreach ( $folders as $page )
                                        <option value="{{ $page->id }}">{{ $page->name }}/</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="image" class="col-md-4 control-label">Afbeelding</label>
                            <div class="col-md-6">
                                <span class="btn btn-default btn-file"><input type="file" accept="bmp,.gif,.jpg,.jpeg,.png" value="{{ old('image') }}" name="image" id="image"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                     <i class="fa fa-plus"></i> Afbeelding opslaan
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
