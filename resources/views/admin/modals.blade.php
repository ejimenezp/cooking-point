
<!-- Modals for CalendarEvent-->

<!-- Delete item -->
<div class="modal fade" id="modal_calendarevent_delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Eliminar Evento</h4>
        </div>
        <div class="modal-body">
          <p>Confirmar</p>
        </div>
        <div class="modal-footer">
            <form >
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                <button type="button" id="modal_button_calendarevent_delete" class="btn btn-primary" >Eliminar</button>
            </form>
       </div>
      </div>

</div>
</div>

<!-- Close edition -->
<div class="modal fade" id="modal_calendarevent_close" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Cerrar</h4>
        </div>
        <div class="modal-body">
          <p>Los cambios se perderán</p>
        </div>
        <div class="modal-footer">
            <form >
                <button type="button" id="modal_button_calendarevent_close" class="btn btn-primary">Cerrar sin guardar</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Seguir editando</button>
                <button type="button" id="modal_button_calendarevent_save" class="btn btn-primary" >Guardar</button>
            </form>
       </div>
      </div>

</div>
</div>

<!-- Add / Update modal -->

<div class="modal fade" id="modal_calendarevent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><div id="modal_calendarevent_title"></div></h4>
        </div>
        <div class="modal-body" id="modal_calendarevent_body"></div>
        <div class="modal-footer">
            <form >
                <button type="button" id="modal_button_calendarevent_ok"  class="btn btn-primary">OK</button>
            </form>
       </div>
      </div>
  </div>
</div>


<!-- Modals for Booking-->

<!-- Delete item -->
<div class="modal fade" id="modal_booking_delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Eliminar Reserva</h4>
        </div>
        <div class="modal-body">
          <p>Confirmar</p>
        </div>
        <div class="modal-footer">
            <form >
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                <button type="button" id="modal_button_booking_delete" class="btn btn-primary" >Eliminar</button>
            </form>
       </div>
      </div>

</div>
</div>

<!-- Close edition -->
<div class="modal fade" id="modal_booking_close" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Cerrar</h4>
        </div>
        <div class="modal-body">
          <p>Los cambios se perderán</p>
        </div>
        <div class="modal-footer">
            <form >
                <button type="button" id="modal_button_booking_close" class="btn btn-primary">Cerrar sin guardar</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Seguir editando</button>
                <button type="button" id="modal_button_booking_save" class="btn btn-primary" >Guardar</button>
            </form>
       </div>
      </div>

</div>
</div>

<!-- Add / Update modal -->

<div class="modal fade" id="modal_booking" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><div id="modal_booking_title"></div></h4>
        </div>
        <div class="modal-body" id="modal_booking_body"></div>
        <div class="modal-footer">
            <form >
                <button type="button" id="modal_button_booking_ok"  class="btn btn-primary">OK</button>
            </form>
       </div>
      </div>
  </div>
</div>

<!-- Add / Update modal -->

<div class="modal fade" id="modal_booking_validation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><div id="modal_booking_validation_title"></div></h4>
        </div>
        <div class="modal-body" id="modal_booking_validation_body"></div>
        <div class="modal-footer">
            <form >
                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
            </form>
       </div>
      </div>
  </div>
</div>
