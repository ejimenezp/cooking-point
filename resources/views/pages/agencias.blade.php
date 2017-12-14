@extends('masterlayout')

@section('title', 'Info para agencias de viaje')
@section('description', 'Información para agencias de viajes, receptivos y organizadores de eventos')

@section('page', 'eventos')
@section('banner-caption', 'info para agencias de viajes')

@section('content')

<h1 class="header1">Nuestros servicios</h1>

<div class="row">
	<div class="col-sm-12">
		<p>Ofrecemos clases de cocina en inglés a viajeros individuales o en grupo de visita en Madrid. Por su temática, localización y horarios, son ideales para aquellos que quieren conocer más de la cultura gastronómica española y/o buscan una experiencia divertida.</p>

		<p>Estamos muy orgullosos de ser por 4º año consecutivo el #1 en Clases de Cocina en Madrid según TripAdvisor.</p>

	</div>
</div>

<div class="no-gutter">
	<div class="col-md-6">
		<h2 class="header2">Clases privadas para grupos</h2>
		<p>Las clases para grupos privados son una versión condensada de las clases diarias de paella o tapas. La dinámica es similar, es decir, se cocina en equipos de 2 o 3 personas y cada equipo hace su propio menú.</p>

		<p>Capacidad máxima: 24 personas.</p>
	</div>

	<div class="col-md-6">

		<h2 class="header2">Viajeros Individuales</h2>
		<p>Tenemos un precio neto muy competitivo para clientes individuales. Un simple correo electrónico bastará para reservar su plaza. Te enviaremos un voucher personalizado para que lo compartas con tu cliente si lo crees conveniente.</p>

	</div>
</div>

<div class="divider"></div>

<div class="row">
	<div class="cp-class-details col-xs-offset-1 col-xs-10 col-md-offset-2 col-md-8">
		<strong>Clases Privadas:</strong> Bajo petición<br/>
		<strong>Duración:</strong> 3 horas (recomendado), turno comida o cena<br/>
		<strong>Precio: </strong>En función del tamaño de grupo. Consultar<br/>
		<strong>Incluye: </strong>Clase de cocina, recetas, comida y bebida<br/><br/>
		<div class="text-center">
			<a href="mailto:info@cookingpoint.es" class="btn btn-primary">Escríbenos</a>
		</div>
	</div>	
</div>

@stop