
<!-- Modals for Online Booking -->

<!-- Edit booking after payment -->

<div class="modal" id="modal_booking_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Booking</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        @if (isset($bkg) && $bkg->fixed_date)
        <div class="modal-body">You can:
          <ul>
              <li><a href="#step2" class="step" data-dismiss="modal">Change contact details or comments</a></li>
          </ul>     
        </div>    
        @else
        <div class="modal-body">You can modify any data except the number of participants
          <ul>
              <li><a href="#" id="date_edit" data-dismiss="modal">Change class date or type</a></li>
              <li><a href="#step2" class="step" data-dismiss="modal">Change contact details or comments</a></li>
              <li><a href="#" id="booking_cancel" data-dismiss="modal">Cancel booking</a></li>  
          </ul>     
          <div class="hidden" id="booking_cancel_confirm"></div>  
        </div> 
        @endif
          <div class="modal-footer">             
            <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
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
          <h4 class="modal-title">Help</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">Select class and number of guests. Calendar will show our availability:
        <table class="help-table">
          <tr>
            <td class="td-available" style="border-radius:7px;">25</td>
            <td>=</td>
            <td>Class available</td>
          </tr>
          <tr>
            <td class="td-last-seats" style="border-radius:7px;">25</td>
            <td>=</td>
            <td>Class available, almost full</td>
          </tr>
          <tr>
            <td class="td-disabled" style="border: 1px solid #ddd; border-radius:7px;">25</td>
            <td>=</td>
            <td>No class, booking closed or not enough room for your party</td>
          </tr> 
          <tr>
            <td class="td-available" style="border: 3px solid #ddd; background-color: darkgreen; border-radius:7px;">25</td>
            <td>=</td>
            <td>Date selected</td>
          </tr>   
         </table>
        <p><br>On next page, fill in your name and email. You can also modify guest details after checkout.</p>
          </div>    
          <div class="modal-footer">             
            <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
          </div>
      </div>
  </div>
</div>

<!-- Generic modal  -->

<div class="modal fade" id="modal_booking" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title modal_booking_title"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body modal_booking_body"></div>
        <div class="modal-footer">
            <form >
<!--                 <button type="button" class="btn btn-light btn-cancel hidden" data-dismiss="modal">Cancel</button>
 -->                <button type="button" class="btn btn-primary btn-ok" data-dismiss="modal">OK</button>
            </form>
       </div>
      </div>
  </div>
</div>


