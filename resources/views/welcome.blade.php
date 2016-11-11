@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welkom bij WebTinq</div>

                <div class="panel-body">

                    <div class="container">
                        <div class="row">
                            <div class="col-md-4 col-md-offset-1">
                                    <p>WebTinq is een online <abbr title="Hypertext Markup Language: de taal achter websites.">HTML</abbr> editor voor kinderen,<br> om webpagina's mee te bouwen én te publiceren..</p>
                            </div>
                            <div class="col-md-4">
                                    <div class="btn-container">
                                            <a href="login" class="btn btn-primary">Login</a>
                                    </div>
                                    <div class="btn-container">
                                            <a href="register" class="btn btn-primary">Registreer</a>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
