@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Over WebTinq</div>
                <div class="panel-body">
                    <h1>WebTinq</h1>
                    <p style="color:#666;">
                        WebTinq is bedacht door <a href="https://www.linkedin.com/in/louiswolf" target="_blank">Louis Wolf</a> en tot stand gekomen dankzij het <a href="https://www.sidnfonds.nl/" target="_blank">SIDN Fonds</a>.
                        WebTinq is de realisatie van een <a href="https://www.sidnfonds.nl/projecten/html-websites-programmeren-en-publiceren-voor-kinderen" target="_blank">SIDN Fonds 2016 pioneer project</a>.
                        Bekijk ook de <a href="{{ url('/download/grant-request') }}" target="_blank">originele aanvraag</a> en <a href="https://www.youtube.com/watch?v=u0fSGzRnz70" target="_blank">videopitch</a>.
                    </p>
                    <p style="color: #666;">
                        WebTinq is een online <abbr title="HyperText Markup Language">HTML</abbr> editor voor kinderen. Er bestaan welliswaar meer online (HTML) editors,
                        maar WebTinq is de eerste Nederlandstalige HTML editor voor kinderen. Andere editors zijn gericht op
                        volwassen, Engelstalige professionals en daardoor ongeschikt voor gebruik in de klas of bijvoorbeeld een CoderDojo.
                    </p>
                    <p style="color: #666;">
                        WebTinq is <a href="https://github.com/louiswolf/webtinq" target="_blank">open source</a> software kan <strong>gratis</strong> gebruikt worden.
                    </p>
                    <h1>Voor Leerlingen</h1>
                    <p style="color: #666;">
                        WebTinq is bedoeld als digitaal gereedschap voor kinderen, om ze te leren hoe ze een website kunnen bouwen in HTML.
                        Gebouwde websites kunnen direct online gepubliceerd worden.
                    </p>
                    <h1>Voor Leraren &amp; Begeleiders</h1>
                    <p style="color:#666;">Hoewel WebTinq is bedacht voor kinderen, is het onze filosofie dat het verstandig is
                        om volwassenen toezicht te laten houden op wat er door kinderen online wordt geplaatst.
                        Denk hierbij bijvoorbeeld aan persoonlijke gegevens. Programmeren is wat ons beteft ook een stukje mediawijsheid.
                    </p>
                    <p style="color: #666;">
                        Met bovenstaande in het achterhoofd is WebTinq zo ingericht dat er altijd een begeleider account geregistreerd moet worden, voordat
                        er een leerling account aangemaakt kan worden.
                    </p>
                    <p style="color: #666;">
                        Vragen over het gebruik van WebTinq? Neem <a href="{{ url('/contact') }}">contact</a> met ons op.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
