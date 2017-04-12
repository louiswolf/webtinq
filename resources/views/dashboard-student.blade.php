@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row">
        <div class="col-md-12" style="text-align: right;">
            <ul style="list-style: none;">
                <li style="display:inline-block;margin-left:10px">
                    <a href="{{ url('/dashboard') }}" class="active">Dashboard</a>
                </li>
                <li style="display:inline-block;margin-left:10px">
                    <a href="{{ url('/settings') }}">Jouw Instellingen</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (count($sites))
                        <table style="width: 100%;">
                            <tr>
                                <th>Site</th>
                                <th>Slug</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        @foreach( $sites as $site )
                            <tr>
                                <td><a href="{{ url( 'editor/' . $site->id ) }}">{{ $site->name }}</a></td>
                                <td>{{ $site->slug }}</td>
                                <td>
                                    <a href="{{ url( 'editor/' . $site->id ) }}" class="btn bnt-primary">Pagina's Bewerken</a>
                                    <a href="{{ url( 'site-settings/' . $site->id ) }}" class="btn bnt-primary">Instellingen</a>
                                    <a href="{{ url( $site->slug . '/index.html' ) }}" target="_blank" class="btn bnt-primary">Bekijk</a>
                                    <a href="{{ url( 'delete-site/' . $site->id ) }}" class="btn bnt-primary" onclick="return warning_delete('{{ $site->name }}');">Verwijder</a>
                                </td>
                            </tr>
                        @endforeach
                        </table>
                    @else
                        <span>Geen sites gevonden</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-primary" href="new-site"><i class="fa fa-plus"></i> Nieuwe site</a>
        </div>
    </div>
</div>
<script>
    function warning_delete(title) {
        return confirm('Je gaat de site ' + title + ' verwijderen. Zeker weten?');
    }
</script>
@endsection
