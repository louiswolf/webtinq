@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12" style="text-align: right;">
            <ul style="list-style: none;">
                <li style="display:inline-block;margin-left:10px">
                    <a href="{{ url('editor/' . $site->id ) }}">Pagina's bewerken</a>
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
                    <div class="panel-heading">Site Instellingen</div>

                    <div class="panel-body">
                    @include('common.errors')

                        <form name="form-editor" id="form-editor" class="form-horizontal" role="form" method="post" action="{{ url('post-site-settings') }}">
                            {{ csrf_field() }}

                            <input type="hidden" id="site_id" name="site_id" value="{{ $site->id }}">

                            <div class="form-group">
                                <label for="title" class="col-md-2 form-label">Site naam</label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" name="site_name" id="site_name" value="{{ $site->name }}"> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="slug" class="col-md-2 form-label">Slug</label>
                                <div class="col-md-5">
                                    <input class="form-control" type="text" name="site_slug" id="site_slug" value="{{ $site->slug }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="slug" class="col-md-2 form-label">Zichtbaarheid</label>
                                <div class="col-md-5">
                                    @if (!$site->published)<span class="btn btn-warning">Offline</span>@endif
                                    @if ($site->published)<span class="btn btn-success">Online</span>@endif
                                    &nbsp;&nbsp;<a href="{{ url('editor/'.$site->id.'/toggle-published') }}">@if ($site->published) Haal Offline @else Zet Online @endif</a>
                                </div>
                            </div>

                            <div class="form-group"><p>&nbsp;</p></div>

                            <div class="form-group">
                                <div class="col-md-5">
                                    <button class="btn btn-primary"><i class="fa fa-save"> </i> Instellingen opslaan</button>
                                    <span>&nbsp;</span>
                                    <a href="{{ url('editor/' . $site->id ) }}" class="btn btn-primary">Pagina's bewerken</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
