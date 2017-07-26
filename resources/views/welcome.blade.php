@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3" style="text-align: center;font-size: 20px">
                <p><img src="logo-main.png" width="300"></p>
                <p>&nbsp;</p>
                <p>WebTinq is een online <abbr title="Hypertext Markup Language: de taal achter websites.">HTML</abbr> editor voor kinderen,<br> om webpagina's mee te bouwen én te publiceren..</p>
                <p>&nbsp;</p>
                @if (Auth::user())
                    <div class="btn-container">
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary" style="font-size: 20px;">Naar jouw dashboard</a>
                    </div>
                @endif
                @if (!Auth::user())
                    <div class="btn-container">
                        <a href="login" class="btn btn-primary" style="font-size: 20px;">Login</a>
                    </div>
                    <div class="btn-container">
                        <a href="register" class="btn btn-primary" style="font-size: 20px;">Registreer</a>
                    </div>
                @endif
                <p>&nbsp;</p>
                <p style="font-size: 12px;">WebTinq is mogelijk gemaakt door het <a href="https://www.sidnfonds.nl/" target="_blank">SIDN Fonds</a>.</p>
            </div>
        </div>
    </div>
@endsection
