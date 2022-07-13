@component('mail::message')
<p>Oprima el boton para confirmar que esta solicitando cambio de clave.</p>
<p> La solicitud de cambio de clave sera efectiva desde la llegada de este correo hasta la fecha y hora: {{$exp}} </p>
@component('mail::button', ['url' => $url])
Confirmar correo
@endcomponent
@endcomponent