@extends('masterlayout')

@section('title', 'Eventos de empresa')
@section('description', 'Eventos de team-building para empresas y cooking parties para grupos privados')

@section('content')

<div class="row">
    <div class="cp-slideshow">
            <div style="display: inline-block;"><img src="/images/slider-events-01.jpg" ></div>
            <div><img src="/images/slider-events-02.jpg" ></div>
    </div>
</div>


<div class="row">
	<div class="col-sm-12">
		<h1>Eventos Privados</h1>
		<p>Ponemos a vuestra disposición nuestras instalaciones y equipo para realizar eventos corporativos o particulares. En todos los casos, los participantes se dividen en pequeños equipos para preparar el menú acordado. La actividad termina con la cena de lo que se ha preparado durante la clase.</p>
	</div>

</div>

<div class="row">
	<div class="col-sm-6">
		<h1>Eventos de empresa</h1>
		<p>Una cocina es un excelente marco para un evento de team building. Los participantes deben preparar su propio menú siguiendo las instrucciones de nuestro chef, lo cual da pie a situaciones divertidas a la vez que aprenden a cocinar platos no tan habituales.</p>

		<p>Una vez termina la preparación, el equipo se traslada al comedor para disfrutar del trabajo en la cocina.</p>
	</div>

	<div class="col-md-6">

		<h1>Actividades para grupos de amigos</h1>
		<p>Si estás pensando en una despedida de soltera o soltero diferente, o una reunión familiar o de amigos, podemos preparar una clase de cocina divertida, con platos o ingredientes no tan habituales, en las que el objetivo es pasar un rato agradable compartiendo la cocina con tus seres queridos.</p>

	</div>
</div>

<div class="divider"></div>

<div class="row call-to-action">
	<div class="col-xs-12 col-sm-1 text-center">
 		<i class="brand-red fa fa-4x fa-info-circle"></i><br/>
	</div>
	<div class="col-xs-3 col-sm-2 what">
		Cuando:<br/>
		Horario:<br/>
		Precio:<br/>
		Include:<br/><br/>
	</div>
	<div class="col-xs-9">
		Bajo petición<br/>
		3 horas (recomendado), en turno de comida o cena<br/>
		Consultar<br/>
		Clase de cocina, recetas, comida y bebida<br/><br/>
	</div>
</div>

<div class="row text-center call-to-action">
	<a href="mailto:info@cookingpoint.es" class="btn btn-primary">Escríbenos</a>
</div>

@stop