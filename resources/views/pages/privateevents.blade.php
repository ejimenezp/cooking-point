@extends('masterlayout')
@section('title', 'In-person Private Events')
@section('description', 'We offer private cooking events for team building or private groups from our cooking school in Madrid')

@section('banner')
<div class="section-banner">
	<div class="d-block d-md-none">
		<img class="img-fluid lazyload" data-src="/images/eventos-banner-sm.jpg" alt="private events from madrid">
	</div>
	<div class="d-none d-md-block">
		<img class="img-fluid lazyload" data-src="/images/eventos-banner.jpg" alt="private events from madrid">
	</div>
</div>
@stop

@section('content')
<h1>Private Events</h1>
<div class="row justify-content-right">
	<div class="col-12">
		<p>We offer you our facilities and experience to organize a corporate event or friends meeting, with our kitchen as the central point.</p>
		<p>También tenemos actividades para público español. El menú y la dinámica cambia un poco, para hacerla más atractiva a las preferencias locales.</p>
		<div class="row justify-content-center">

	    <div class="col-sm-6">
	            <div class="box all-clickable orange-on-hover">
	                <a href="/private-cooking-events-madrid-spain"></a>
	                <img class="img-fluid lazyload" title="cooking events" alt="private cooking events in Madrid" data-src="/images/events-banner-sm.jpg" />    
	                <h2>In English</h2>
	                <p>We can customize our classes as private events for corporate groups, team buildings, hen or stag parties, school trips or just group of friend that want to have a different lunch or dinner in Madrid.</p>
	            </div>            
	    </div>

	    <div class="col-sm-6">
	            <div class="box all-clickable orange-on-hover">
	                <a href="/actividades-team-building-empresas-madrid"></a>
	                <img class="img-fluid lazyload" title="team building empresas" alt="team bulding empresas in Madrid" data-src="/images/eventos-banner-sm.jpg" />    
	                <h2>En español</h2>
	                <p>Ofrecemos actividades para empresas orientadas a equipos españoles que quieren realizar un team building de cocina en el centro de Madrid.</p>
	            </div>            
	    </div>
<!-- 	    <div class="col-sm-6">
	            <div class="box all-clickable orange-on-hover">
	                <a href="/private-online-events"></a>
	                <img class="img-fluid lazyload" title="cooking events" alt="private cooking events in Madrid" data-src="/images/team-building-online-banner-sm.jpg" />    
	                <h2>Online Events</h2>
	                <p>As a mirror of our in-person events we offer live online classes where participants follow from home our chef directions to prepare a Spanish menu.</p>
	            </div>            
	    </div> -->
		</div>
	</div>
</div>

<!-- <div class="row justify-content-right">
	<div class="col-12">
		<h3>En español</h3>
		<p>También tenemos actividades para público español. El menú y la dinámica cambia un poco, para hacerla más atractiva a las preferencias locales.</p>

		<div class="row justify-content-center">

	    <div class="col-sm-6">
	            <div class="box all-clickable orange-on-hover">
	                <a href="/actividades-team-building-empresas-madrid"></a>
	                <img class="img-fluid lazyload" title="team building empresas" alt="team bulding empresas in Madrid" data-src="/images/eventos-banner-sm.jpg" />    
	                <h2>En nuestro local</h2>
	                <p>Ofrecemos actividades para empresas orientadas a equipos españoles que quieren realizar un team building de cocina en el centro de Madrid.</p>
	            </div>            
	    </div>

	    <div class="col-sm-6">
	            <div class="box all-clickable orange-on-hover">
	                <a href="/actividades-team-building-online"></a>
	                <img class="img-fluid lazyload" title="team building" alt="team building online" data-src="/images/eventos-online-banner-sm.jpg" />    
	                <h2>Eventos Online</h2>
	                <p>Organizamos actividades online para empresas donde los colaboradores cocinan desde sus casas siguiendo las instrucciones de nuestro chef por video conferencia.</p>
	            </div>            
	    </div>
		</div>
	</div>
</div> -->

<div class="row justify-content-right">
	<div class="col-12">
		<h3>We are in Evendo</h3>
		<p>Evendo is everything you need to arrange better events and celebrations. By combining the World&rsquo;s biggest marketplace for Event-related products with a suite of easy-to-use tools, you will be choosing between 100,000&rsquo;s of bookable activities, experiences, venues, restaurants, transportation...</p>
    <table border="0" cellpadding="10" cellspacing="0" align="center"><tr><td align="center"><a target="_blank" href="https://www.evendo.com"><img class="img-fluid lazyload" title="evendo" alt="eventdo" data-src="https://images.evendo.com/cdn-cgi/image/f=auto,width=1900,quality=75/images/b67dfef47dbd4eabb7cebcd6952d2b97.png" /></a></td></tr></table>
	</div>
</div>

<div class="divider"></div>


<h3>Not Decided Yet?</h3>
<div class="row justify-content-center">
	<div class="col-lg-4">
		<div class="bottom-gutter">
			<div class="box all-clickable orange-on-hover">
				<a href="/best-cooking-classes-madrid"></a>
				<img class="img-fluid lazyload" data-src="/images/bestintown_logo.png" alt="best classes in town" />
				<h4 style="margin-top: 0.5rem;">10 Reasons Why</h4>
				<p>Find out why we think we are the best classes in town</p>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="bottom-gutter">
			<div class="box all-clickable orange-on-hover">
				<a href="/gallery"></a>
				<img class="img-fluid lazyload" data-src="/images/tripadvisor-photo.jpg" alt="photo gallery" />
				<h4 style="margin-top: 0.5rem;">Photo Gallery</h4>
				<p>Check out client photos on social media</p>
			</div>
		</div>
	</div>
</div>
@stop

@section('bottom-filler')
<div class="d-block d-md-none">
	<div style="height: 9rem;"></div>
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
				<form>
					<button type="button" class="btn btn-primary btn-ok" data-dismiss="modal">OK</button>
				</form>
			</div>
		</div>
	</div>
</div>
@stop

@section('js')
<script defer src="{{ mix('/js/contactonlineclasses.js') }}"></script>
@stop
