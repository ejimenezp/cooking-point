@extends('masterlayout')

@section('title', 'Contacto para Eventos')
@section('description', 'Formulario para solicitar información sobre eventos privados')

@section('content')

<h1 class="header1">Solicitud Información</h1>

<div class="row">
      <div class="col-xs-12">
            Dinos fecha del evento, número de personas y cualquier otro dato que consideres oportuno. Te enviaremos una propuesta en 24 horas:<br/><br/>
      </div>
	<div class="col-xs-12 col-md-offset-1 col-md-10">
            <form id="form_contactoeventos">
                  <table style="width: 100%">
                        <tbody>                              
                              <tr>
                                    <td class="bold">
                                          Tu nombre <span class="mandatory">*</span> :
                                    </td>
                              </tr>
                              <tr>
                                    <td>
                                          <input name="name" type="text" value="" >
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
                                          <input name="email" type="text" value="" >
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
                                          <a id="button_contacto_form" class="btn btn-primary">Enviar</a>
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
            </form>
	</div>
</div>

<div class="row">
      <div class="col-sm-12">

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
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title modal_contactoeventos_title"></h4>
        </div>
        <div class="modal-body modal_contactoeventos_body"></div>
        <div class="modal-footer">
            <form >
                <button type="button" class="btn btn-default btn-cancel hidden" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btn-ok" data-dismiss="modal">OK</button>
            </form>
       </div>
      </div>
  </div>
</div>
@stop

@section('js')
      <script async src="{{ elixir('js/contactoeventos.js') }}"></script>
@stop
