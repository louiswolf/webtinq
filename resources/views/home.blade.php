@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1" style="text-align: right;">
            <ul style="list-style: none;">
                <li style="display:inline-block;margin-left:10px">
                    <a href="{{ url('/new-student') }}">Nieuwe Leerling</a>
                </li>
                {{--
                <li style="display:inline-block;margin-left:10px">
                    <a href="{{ url('/import-students') }}">Importeer Leerlingen</a>
                </li>
                --}}
                @if ( $user_status === 1 )
                    <li style="display:inline-block;margin-left:10px">
                        <a href="{{ url('/system-admin') }}">System admin</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
    <div class="row">
        <form name="form-editor" id="form-editor" class="form-horizontal" role="form" method="post" action="{{ url('/post-update-students') }}">
        {{ csrf_field() }}
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">

                    @if (count($students))
                        <table style="width: 100%;">
                            <tr>
                                <th></th>
                                <th>Naam</th>
                                <th>Site</th>
                                <th>Gepubliceerd</th>
                                <th>Geblokkeerd</th>
                                <th></th>
                                <th></th>
                            </tr>
                        @foreach( $students as $student )
                            <tr>
                                <td></td>
                                <td><input id="student[]" name="student[]" value="{{ $student->id }}" type="checkbox"><a href="{{ url('/settings') }}?owner={{ $student->id }}"> {{ $student->name }}</a></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @foreach( $student->sites as $site )
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>{{ $site->name }}</td>
                                    <td><input id="publish[]" name="publish[]" value="{{ $site->id }}" type="checkbox" @if ( $site->published) checked="checked" @endif></td>
                                    <td><input id="block[]" name="block[]" value="{{ $site->id }}" type="checkbox" @if ( $site->blocked) checked="checked" @endif></td>
                                    <td><a href="{{ url('/editor/' . $site->id) }}?owner={{ $student->id }}" class="btn bnt-primary">Beheer</a></td>
                                    <td><a href="{{ url( $site->slug . '/index.html' ) }}" target="_blank" class="btn bnt-primary">Bekijk</a></td>
                                </tr>
                            @endforeach
                        @endforeach
                        </table>
                    @else
                        <span>Geen leerlingen gevonden</span>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 col-md-offset-1">
            <div style="display:inline-block;margin-right:20px;">
                <button class="btn btn-primary btn-submit"><i class="fa fa-save"> </i> Wijzigingen opslaan</button>
            </div>
        </div>
        <div class="col-md-9">
            <div style="display:inline-block;margin-right:20px;">
                <button class="btn btn-primary btn-submit" name="open_portal" value="open_portal"><i class="fa fa-plus"> </i> Nieuw klasportaal</button>
                <button class="btn btn-primary btn-submit" name="manage_portals" value="manage_portals"><i class="fa fa-edit"> </i> Beheer klasportalen</button>
                <button class="btn btn-primary btn-submit" name="print_logins" value="print_logins"><i class="fa fa-print"> </i> Print logins</button>
            </div>
        </div>
    </div>
    </form>
</div>
@endsection
