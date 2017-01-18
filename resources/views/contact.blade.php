@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Contact</div>
                <div class="panel-body">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                    @if(Session::has('message'))
                        <div class="alert alert-info">
                            {{Session::get('message')}}
                        </div>
                    @endif

                    {!! Form::open(array('route' => 'contact_submit', 'class' => 'form')) !!}

                    <div class="form-group">
                        {!! Form::label('Uw naam') !!}
                        {!! Form::text('name', null,
                            array('required',
                                  'class'=>'form-control',
                                  'placeholder'=>'Uw naam')) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('Uw e-mail adres') !!}
                        {!! Form::text('email', null,
                            array('required',
                                  'class'=>'form-control',
                                  'placeholder'=>'Uw e-mail adres')) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('Uw bericht') !!}
                        {!! Form::textarea('message', null,
                            array('required',
                                  'class'=>'form-control',
                                  'placeholder'=>'Uw bericht')) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::submit('Verstuur bericht',
                          array('class'=>'btn btn-primary')) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
