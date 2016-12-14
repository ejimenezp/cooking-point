
<!-- Modals for Online Booking -->

<!-- Edit booking after payment -->

<div class="modal" id="modal_booking_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Booking</h4>
        </div>
        <div class="modal-body">You can modify any data except the number of participants
          <ul>
              <li><a href="#step1" class="step" data-dismiss="modal">Change class date or type</a></li>
              <li><a href="#step2" class="step" data-dismiss="modal">Change contact details or comments</a></li>
              <li><a id="booking_cancel" data-dismiss="modal">Cancel booking</a></li>  
              <div class="hidden" id="booking_cancel_confirm"></div>  
          </ul>     
          </div>    
          <div class="modal-footer">             
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
      </div>
  </div>
</div>

<!-- Booking Help -->

<div class="modal" id="modal_booking_help" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Help</h4>
        </div>
        <div class="modal-body">Please, select the desired date, class and number of guests. The calendar will update according to our availability:
        <table class="help-table">
          <tr>
            <td class="td-available">25</td>
            <td>= Room available</td>
          </tr>
          <tr>
            <td class="td-last-seats">25</td>
            <td>= Class almost complete with your party</td>
          </tr>
          <tr>
            <td class="td-disabled">25</td>
            <td>= Class not available or not enough room for your party</td>
          </tr>  
        </table>
        <p>You will be requested your name, email address and some other details later on.  You can also fill in these data after checking out.</p>
          </div>    
          <div class="modal-footer">             
            <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
          </div>
      </div>
  </div>
</div>

<!-- Booking Retrieve -->

<div class="modal fade" id="modal_booking_retrieve" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Retrieve Booking</h4>
        </div>
        <form id="retrieve-form" action="/booking">
          <div class="modal-body">If you already have a booking number, you can access your booking from any device or browser.
            <table class="availability-table">
              <tbody>
                <tr>
                  <td class="bold availability-row">
                    Booking #:
                  </td>
                  <td>
                    <input name="locator" type="text" value="" >
                  </td>
                </tr>
              </tbody>
            </table>
          </div>    
          <div class="modal-footer">             
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Send</button>
          </div>
        </form>
      </div>
  </div>
</div>


<!-- Generic modal  -->

<div class="modal fade" id="modal_booking" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title modal_booking_title"></h4>
        </div>
        <div class="modal-body modal_booking_body"></div>
        <div class="modal-footer">
            <form >
                <button type="button" class="btn btn-default btn-cancel hidden" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btn-ok" data-dismiss="modal">OK</button>
            </form>
       </div>
      </div>
  </div>
</div>


