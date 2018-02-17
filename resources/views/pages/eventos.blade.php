@extends('masterlayout')

@section('title', 'Eventos de empresa')
@section('description', 'Organizamos team-building de cocina para empresas y cooking parties para grupos privados. Estamos en el centro de Madrid.')

@section('page', 'eventos')
@section('banner-caption', 'evento de empresa en cooking point')

@section('content')

<h1 class="header1">Eventos Privados</h1>

<div class="row">
	<div class="col-sm-12">
		<p>Ponemos a vuestra disposición nuestras instalaciones y equipo para realizar eventos corporativos o particulares. En todos los casos, los participantes se dividen en pequeños equipos para preparar el menú acordado. La actividad termina con la comida o cena de lo que se ha preparado durante la clase.</p>
	</div>

{{--     <div class="home-notice col-xs-offset-1 col-xs-10 col-md-offset-2 col-md-8">
        <strong>Especial Navidad para Empresas</strong><br/>
        Prepara y disfruta con tu equipo de un menú de Navidad de 5 estrellas. Pregúntanos.<br/>
    </div>   --}}

</div>

<div class="no-gutter">
	<div class="col-md-6">
		<h2 class="header2">Eventos de empresa</h2>
		<p>Una cocina es un excelente marco para un evento de team building. Los participantes deben preparar su propio menú siguiendo las instrucciones de nuestro chef, lo cual da pie a situaciones divertidas a la vez que aprenden a cocinar platos no tan habituales.</p>

		<p>Una vez termina la preparación, el equipo se traslada al comedor para disfrutar del trabajo en la cocina.</p>
	</div>

	<div class="col-md-6">

		<h2 class="header2">Actividades para grupos de amigos</h2>
		<p>Si estás pensando en una despedida de soltera o soltero diferente, o una reunión familiar o de amigos, podemos preparar una clase de cocina divertida, con platos o ingredientes no tan habituales, en las que el objetivo es pasar un rato agradable compartiendo la cocina con tus seres queridos.</p>

	</div>
</div>

<div class="divider"></div>

<div class="row">
	<div class="cp-class-details col-xs-offset-1 col-xs-10 col-md-offset-2 col-md-8">
		<strong>Cuando:</strong> Bajo petición<br/>
		<strong>Duración:</strong> 3 horas (recomendado), turno comida o cena<br/>
		<strong>Precio: </strong>En función del tamaño de grupo. Consultar<br/>
		<strong>Incluye: </strong>Clase de cocina, recetas, comida y bebida<br/><br/>
		<div class="text-center">
			<a href="mailto:info@cookingpoint.es" class="btn btn-primary">Escríbenos</a>
		</div>
	</div>	
</div>

@stop