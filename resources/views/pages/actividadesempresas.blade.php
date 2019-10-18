@extends('masterlayout')

@section('title', 'Team Building de Cocina en Madrid')
@section('description', 'Organizamos team-building de cocina para empresas y cooking parties para grupos privados. Estamos en el centro de Madrid.')

@section('banner-name', 'eventos')
@section('banner-caption', 'evento de empresa en cooking point')

@section('content')

<h1 class="header1">Actividades para empresas</h1>

<div class="row justify-content-right">
	<div class="col-12">
		<p>Ponemos a vuestra disposición nuestra escuela de cocina y equipo de chefs para realizar actividades para empresas en el centro de Madrid.</p>

		<h2 class="header2">Team building en la cocina: hoy cocina mi equipo</h2>
		<p>Una cocina es un excelente marco para una actividad de team building para empresas. En nuestras actividades se comprueba el valor del trabajo en equipo, pues los resultados son tangibles en forma de una suculenta comida o cena de empresa.</p>

		<p>Al modo de un Masterchef de la tele, el grupo se divide en equipos para elaborar un menú degustación siguiendo las instrucciones de nuestros chefs. Habrá momentos de aprendizaje, trabajo minucioso y creatividad, pero también situaciones divertidas y de relax. Todo con el fin de propiciar conoceros mejor entre vosotros en un ambiente distendido.</p>

		<p>Nuestro team building de cocina os propone platos, técnicas e ingredientes habituales en el panorama de la restauración actual. Nos gusta la cocina sencilla, diversa y con rigor técnico, pero con aplicación también en tu vida personal.</p>

		<h2 class="header2">Solicita Información</h2>

        <p>Dinos fecha del evento, número de personas y cualquier otro dato que consideres oportuno. Te enviaremos una propuesta en 24 horas:</p>

		<div class="row">
			<div class="offset-md-1 col-md-10 col-sm-10">
				<table style="width: 100%">
				    <tbody>                              
				          <tr>
				                <td class="bold">
				                      Tu nombre <span class="mandatory">*</span> :
				                </td>
				          </tr>
				          <tr>
				                <td>
				                      <input name="name" type="text" >
				                      <p></p>
				                </td>
				          </tr>
				          <tr>
				                <td class="bold">
				                      Tu e-mail <span class="mandatory">*</span> :
				                </td>
				          </tr>
				          <tr>
				                <td>
				                      <input name="email" type="text" >
				                      <p></p>
				                </td>
				          </tr>
				          <tr>
				                <td class="bold" >
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
				                      <span class="mandatory">*</span>: Solo lo usaremos para contestar tu petición. No haremos spam.
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
      <script async src="{{ mix('/js/contactoeventos.js') }}"></script>
@stop


