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
                <div class="panel-heading">System admin</div>

                <div class="panel-body">
                    @include('common.errors')

                    <form class="form-horizontal" role="form" method="post" action="{{ url('/import-schools') }}">
                        {{ csrf_field() }}

                        <div class="form-group">

                            <label for="name" class="col-md-4 control-label">DUO Scholenlijst (<a href="https://duo.nl/open_onderwijsdata/databestanden/po/adressen/" target="_blank">Download</a>)</label>

                            <div class="col-md-6">
                                <input id="school-data-file" type="file" class="form-control" name="school-data-file" value="{{ old('school-data-file') }}" accept=".csv">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                     <i class="fa fa-plus"></i> Importeer scholen (TODO)
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
