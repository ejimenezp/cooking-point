@extends('masterlayout')
@section('title', 'Online Private Cooking Events from Madrid')
@section('description', 'Enjoy an online private cooking event for your corporate team building or family event, with our cook from Madrid.')

@section('banner')
<div class="section-banner">
	<div class="d-block d-md-none">
		<img class="img-fluid lazyload" data-src="/images/team-building-online-banner-sm.jpg" alt="online cooking private event from madrid">
	</div>
	<div class="d-none d-md-block">
		<img class="img-fluid lazyload" data-src="/images/team-building-online-banner.jpg" alt="online cooking private event from madrid">
	</div>
</div>
@stop


@section('content')
<h1>Online Private Events</h1>

<p>As a mirror of our in-person private events we offer live online events where participants follow from home our chef directions to prepare a Spanish menu.</p>

<p>It is an interactive step-by-step class where participants replicate chef's tasks while he monitors their work so that everybody can get a worthy result. The activity is in English and is led by a local chef.</p>

<ul style="padding-left: 1rem;">
<li>Surprise your family and friends organizing a <strong>cooking party</strong> and give family video calling a boost. Kids will love it too, as there are always tasks for them in class.</li>
<li>How about an <strong>online team building</strong> event? where coworkers show off their culinary skills while having a break from working from home.</li>
<li>Or what about a distinct <strong>extracurricular activity</strong> to improve high school or college remote learning resources?</li>
</ul>

<h3>How it works</h3>
<p>We use <strong><a href="https://zoom.us/" target="_blank">Zoom</a></strong> to stream the classes, so you'll need an account on this service (it's free).</p>
<p>We have selected recipes that don't require rare ingredients, special set-up, or above-average culinary skills. Easy to find, easy to make, ready to eat.</p>

<div class="row justify-content-center">
	<div class="col-lg-10 col-xl-6">
		<figure class="text-center">
			<img data-src="/images/team-building-online-details-01.jpg" class="lazyload img-fluid mx-auto d-block" alt="cooking team building">
			<figcaption class="figure-caption">Team building right from your kitchen</figcaption>
		</figure>
	</div>
	<div class="col-lg-10 col-xl-6">
		<figure class="text-center">
			<img data-src="/images/online-details-02.jpg" class="lazyload img-fluid mx-auto d-block" alt="close-up view">
			<figcaption class="figure-caption">Switch between views at any time so you don't miss any details</figcaption>
		</figure>
	</div>
</div>

<p>As the event leader, you will receive an email to share with the other participants. It contains the following info:</p>
<ul style="padding-left: 1rem;">
	<li>Schedule of the class in your local time.</li>
	<li>A Zoom link to connect to the videocall.</li>
	<li>A <strong>Class Handbook</strong>, a pdf file that contains:</li>
	<ul style="padding-left: 1rem;">
			<li>Recipes.</li>
			<li>Grocery list, with alternative ingredients in case you can't find them or you have dietary requirements.</li>
			<li>Kitchenware checklist, to make sure you have everything at hand during the class.</li>
			<li>Technical guide to get things ready before the class (Zoom instructions, kitchen set-up...).</li>
		</ul>
</ul>
		
<p>The dishes are meant to be eaten after class, but we'll show you ways to store and reheat them later. Recipes are designed for 2 servings, but can be doubled easily. Ask about cuantities if you are cooking for more. </p>

<h3>Inquries</h3>
<p>Contact us to get further details and quotations (here or by email at <a href="mailto:info@cookingpoint.es">info@cookingpoint.es</a>). We'll reply within 24 hours:</p>
<div class="row">
	<div class="offset-md-1 col-md-10 col-sm-10">
		<table style="width: 100%">
			<tbody>
				<tr>
					<td class="font-weight-bold">
						Name
					</td>
				</tr>
				<tr>
					<td>
						<input name="name" type="text">
						<p></p>
					</td>
				</tr>
				<tr>
					<td class="font-weight-bold">
						E-mail <span class="text-danger">*</span>
					</td>
				</tr>
				<tr>
					<td>
						<input name="email" type="email">
						<p></p>
					</td>
				</tr>
				<tr>
					<td class="font-weight-bold">
						Message
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
						<button id="button_contacto_form" class="btn btn-primary">Send</button>
					</td>
				</tr>
				<tr>
					<td style="font-size: small;">
						<p></p>
						<span class="text-danger">*</span>: We'll use it just to reply you. We won't spam.
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

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
