
<!-- Modals for CalendarEvent-->

<!-- Delete item -->
<div class="modal fade" id="modal_calendarevent_delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Eliminar Evento</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>Confirmar</p>
        </div>
        <div class="modal-footer">
            <form >
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
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
          <h4 class="modal-title">Cerrar</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>Los cambios se perderán</p>
        </div>
        <div class="modal-footer">
            <form >
                <button type="button" id="modal_button_calendarevent_close" class="btn btn-secondary">Cerrar sin guardar</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Seguir editando</button>
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
          <h4 class="modal-title"><div id="modal_calendarevent_title"></div></h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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
          <h4 class="modal-title">Eliminar Reserva</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>Confirmar</p>
        </div>
        <div class="modal-footer">
            <form >
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
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
          <h4 class="modal-title">Cerrar</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>Los cambios se perderán</p>
        </div>
        <div class="modal-footer">
            <form >
                <button type="button" id="modal_button_booking_close" class="btn btn-secondary">Cerrar sin guardar</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Seguir editando</button>
                <button type="button" id="modal_button_booking_save" class="btn btn-primary" >Guardar</button>
            </form>
       </div>
      </div>
    </div>
  </div>
  
<!-- save & email it -->
<div class="modal fade" id="modal_booking_save_before_emailit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Atención</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>Debes guardar los cambios antes de enviar email.</p>
        </div>
        <div class="modal-footer">
            <form >
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
            </form>
       </div>
      </div>
    </div>
  </div>


<!-- Agree before sending email -->
<div class="modal fade" id="modal_booking_agree_before_emailit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Atención</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body modal_admin_body"></div>

        <div class="modal-footer">
            <form >
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" id="modal_button_booking_emailit" class="btn btn-primary" >Continuar</button>
            </form>
       </div>
      </div>      
</div>
</div>


<!-- Modals for Blogposts -->

<!-- Delete item -->
<div class="modal fade" id="modal_post_delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Delete Post</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>Post and associated images will be removed. Please confirm</p>
        </div>
        <div class="modal-footer">
            <form >
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="modal_button_post_delete" class="btn btn-primary" >Delete</button>
            </form>
       </div>
      </div>

</div>
</div>

<!-- Generic modal  -->

<div class="modal fade" id="modal_admin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title modal_admin_title"></h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body modal_admin_body"></div>
        <div class="modal-footer">
            <form >
                <button type="button" class="btn btn-primary btn-ok" data-bs-dismiss="modal">OK</button>
            </form>
       </div>
      </div>
  </div>
</div>
