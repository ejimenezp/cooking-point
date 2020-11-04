@extends('masterlayout')

@section('title', 'Team Building de Cocina Online')
@section('description', 'Organizamos team-building online para empresas y cooking parties para grupos privados.')
@section('page-lang', 'es')

@section('banner')
<div class="section-banner">
	<div class="d-block d-md-none">
		<img class="img-fluid lazyload" data-src="/images/team-building-online-banner-sm.jpg" alt="team-building con cooking point" >		
	</div>
	<div class="d-none d-md-block">
		<img class="img-fluid lazyload" data-src="/images/team-building-online-banner.jpg" alt="team-building con cooking point" >		
	</div>	
</div>
@stop

@section('content')

<h1>Team-building Online</h1>

<div class="row justify-content-right">
	<div class="col-12">
		<p>En estos tiempos de pandemia, mantener el equipo unido es más importante que nunca. Os proponemos una actividad online donde los colaboradores cocinan desde sus casas siguiendo las instrucciones de nuestro chef a través de una video conferencia. Esto permite reforzar los vínculos del equipo a través de situaciones divertidas y una sana competencia.</p>

		<p></p>

		<p>Para hacer la clase amena y accesible, hemos seleccionado recetas curiosas, atractivas, pero que no requiren habilidades o utensilios de cocina fuera de lo normal. Usamos ingredientes que se encuentran en cualquier gran superficie pero también proponemos alternativas para personas con dietas especiales (sin gluten, vegetarianos,...). En resumen, fácil de encontrar, fácil de preparar, listo para comer.</p>



		<div class="row justify-content-center">
			<div class="col-lg-10 col-xl-6">
				<figure class="text-center">
					<img data-src="/images/team-building-online-details-01.jpg" class="lazyload img-fluid mx-auto d-block" alt="front view">
					<figcaption class="figure-caption">Emitimos desde una cocina luminosa y sin distracciones</figcaption>
				</figure>
			</div>
			<div class="col-lg-10 col-xl-6">
				<figure class="text-center">
					<img data-src="/images/team-building-online-details-02.jpg" class="lazyload img-fluid mx-auto d-block" alt="close-up view">
					<figcaption class="figure-caption">Tenemos dos cámaras para no perder ningún detalle</figcaption>
				</figure>
			</div>
		</div>

		<h2>Cómo funciona?</h2>
		<p>Usamos <strong><a href="https://zoom.us/">Zoom</a></strong> para la videoconferencia. No es necesario tener cuenta para acceder a la actividad, aunque es recomendable tener la aplicación instalada.</p>

		<p>Una vez confirmada la clase, os enviamos un correo con:</p>
		<ul style="padding-left: 1rem;">
			<li>Fecha y hora de la actividad.</li>
			<li><strong>Manual de Usuario</strong>, un fichero pdf que incluye:</li>
			<ul style="padding-left: 1rem;">
					<li>Recetas.</li>
					<li>Lista de ingredientes, con alternativas en caso de dietas especiales.</li>
					<li>Lista de utensilios de cocina necesarios, para tenerlos a mano durante la clase.</li>
					<li>Guía técnica, con consejos e intrucciones para conectarse a la clase (guía básica de Zoom, cómo preparar la cocina,...)</li>
			</ul>
			<li>Enlace Zoom a la videoconferencia.</li>
		</ul>

		<p>La clase está pensada para disfrutar del menú al finalizar la actividad, para así compartir experiencias entre los participantes en una "mesa virtual" a través de Zoom.</p>

		<h2>Solicita Información</h2>

        <p>Dinos fecha del evento, número de personas y cualquier otro dato que consideres oportuno. Te enviaremos una propuesta en 24 horas:</p>

		<div class="row">
			<div class="offset-md-1 col-md-10 col-sm-10">
				<table style="width: 100%">
				    <tbody>                              
				          <tr>
				                <td class="font-weight-bold">
				                      Tu nombre <span class="text-danger">*</span> :
				                </td>
				          </tr>
				          <tr>
				                <td>
				                      <input name="name" type="text" >
				                      <p></p>
				                </td>
				          </tr>
				          <tr>
				                <td class="font-weight-bold">
				                      Tu e-mail <span class="text-danger">*</span> :
				                </td>
				          </tr>
				          <tr>
				                <td>
				                      <input name="email" type="email" >
				                      <p></p>
				                </td>
				          </tr>
				          <tr>
				                <td class="font-weight-bold" >
				                      Mensaje:
				                </td>
				          </tr>
				          <tr>
				                <td>
				                      <textarea rows="4" name="message"></textarea>
				                      <p></p>
				                </td>
				          </tr>
				          <tr>
				                <td>
				                      <button id="button_contacto_form" class="btn btn-primary">Enviar</button>
				                </td>
				          </tr>
				          <tr>         
				                <td style="font-size: small;">
				                      <p></p>
				                      <span class="text-danger">*</span>: Solo lo usaremos para contestar tu petición. No haremos spam.
				                </td>
				          </tr>
				    </tbody>
				</table>
			</div>
		</div>


	</div>
</div>

@stop

@section('modals')
<!-- Generic modal  -->
<div class="modal fade" id="modal_contactoeventos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title modal_contactoeventos_title"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body modal_contactoeventos_body"></div>
        <div class="modal-footer">
            <form >
                <button type="button" class="btn btn-primary btn-ok" data-dismiss="modal">OK</button>
            </form>
       </div>
      </div>
  </div>
</div>
@stop

@section('js')
      <script defer src="{{ mix('/js/contactoeventos.js') }}"></script>
@stop


