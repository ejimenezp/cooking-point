@extends('masterlayout')

@section('title', 'Address and Directions')
@section('description', 'Located in Barrio de Huertas, within walking distance of major hotel areas and museums. Metro Anton Martin, Line 1.')


@section('banner')
<div class="section-banner">
      <div class="d-block d-md-none">
            <img class="img-fluid lazyload" data-src="/images/location-banner-sm.jpg" alt="cooking point location" >       
      </div>
      <div class="d-none d-md-block">
            <img class="img-fluid lazyload" data-src="/images/location-banner.jpg" alt="cooking point location" >          
      </div>      
</div>
@stop

@section('content')

<h1>Location</h1>

<div class="row justify-content-center">

      <div class="col-12">
            <div class="row">
                  <div class="col-sm-6 ">
                        <div class="pill">
                            <h4>Address</h4>
                              <table class="infogram">
                                  <tr>
                                    <td><div class="icon"><img title="Address" src="/images/icons/maps-and-flags.png"></div></td>
                                    <td><div class="icon"><img title="Transit" src="/images/icons/underground.png"></div></td>
                                    <td><div class="icon"><img title="Opening hours" src="/images/icons/clock.png"></div></td>
                                </tr>
                                   <tr>
                                      <td>Calle de Moratín, 11</td>
                                      <td>Anton Martin (Line 1)</td>
                                      <td>9:30 AM - 9:30 PM</td>
                                </tr>
                              </table>  
                        </div>
                  </div>
                  <div class="col-sm-6">
                        <div class="pill">
                            <h4>Contact</h4>
                              <table class="infogram">
                                  <tr>
                                    <td><div class="icon"><img title="Email" src="/images/icons/email.png"></div></td>
                                    <td><div class="icon"><img title="Phone" src="/images/icons/phone.png"></div></td>
                                </tr>
                                   <tr>
                                      <td><a href="mailto:info@cookingpoint.es">info@cookingpoint.es</a></td>
                                      <td><a href="tel:(+34)910115154">+34 910 115 154</a></td>
                                </tr>
                              </table>  
                        </div>
                  </div>
            </div>
      </div>            
</div>


<div class="row justify-content-center">

      <div class="col-12">
            <p>Cooking Point is located in the Barrio de Huertas (or Barrio de las Letras, Literary Quarter). An important place in history especially during the 16th-century, considered the Golden Age of Spanish Literature. Miguel de Cervantes, author of "Don Quijote de la Mancha" and Lope de Vega both lived here. </p>

      	<p>This quarter is in the heart of Madrid and our school is within walking distance of Madrid landmarks like Museo del Prado or Puerta del Sol. The closest metro station is Anton Martin (line 1, light blue), exit Amor de Dios St.</p>

            <iframe class="lazyload" data-src="https://www.google.com/maps/d/embed?mid=1Z52oFNjEYejtU59SYZuFh3q7EuEIXSxX" style="height: 60vh;width: 100%;"></iframe>

            <p><br>Inside Cooking Point, we have designed our large kitchen to feel like home. The state-of-the-art appliances will ensure nothing can go wrong while all the tools are exactly as you would have in your own kitchen. There is no reason why you won’t be able to take this new-found skill home with you.</p>

            <p>A unique feature of our school is the size, we can host a group of up to 24 people. Large enough for a great atmosphere, small enough to get the right guidance and support from the chef. All cooking is done in pairs, each couple has their own stove to work on.</p>

            <div class="text-center">
                  <a href="http://tour.cookingpoint.es/CP_tour.html" class="btn btn-primary" target="_blank">Virtual Tour</a>           
            </div>

      </div>
    
</div>

@stop


