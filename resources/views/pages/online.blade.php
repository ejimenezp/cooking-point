@extends('masterlayout')
@section('title', 'Online Cooking Classes')
@section('description', 'Join our online classes, live from Madrid and interact with our chef to make your Spanish tapas dinner without leaving your kitchen')
@section('banner')
<div class="section-banner">
	<div class="d-block d-md-none">
		<img class="img-fluid lazyload" data-src="/images/online-banner-sm.jpg" alt="online cooking class from madrid">
	</div>
	<div class="d-none d-md-block">
		<img class="img-fluid lazyload" data-src="/images/online-banner.jpg" alt="online cooking class from madrid">
	</div>
</div>
@stop

@section('content')
<h1>Online Cooking Class</h1>
<div class="row justify-content-center">
	<div class="col-sm-6 ">
		<div class="pill">
			<h4>Highlights</h4>
			<ul>
				<li>Learn at home authentic Spanish recipes</li>
				<li>Schedule adapted to your time zone</li>
				<li>Live class in English</li>
				<li>€40 per adult</li>
			</ul>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="pill">
			<h4>Schedule</h4>
			<table class="infogram">
				<tr>
					<td>
						<div class="icon"><img title="Operating days" src="/images/icons/calendar.png"></div>
					</td>
					<td>
						<div class="icon"><img title="Start time" src="/images/icons/clock.png"></div>
					</td>
					<td>
						<div class="icon"><img title="Duration" src="/images/icons/duration.png"></div>
					</td>
				</tr>
				<tr>
					<td>Monday - Saturday</td>
					<td>3 times a day</td>
					<td>2 hours</td>
				</tr>
			</table>
		</div>
	</div>
</div>
<div class="row justify-content-right">
	<div class="col-12">
		<h3>Description</h3>
		<p>Enjoy from your kitchen a fun cooking class live from our top-rated school in Madrid. Follow our local chef directions in English to prepare an authentic Spanish dinner. This is an <strong>interactive step-by-step class</strong> where you are invited to replicate chef's tasks while he monitors your work so that no one is left behind.</p>
		<p>While you cook <strong>renowned Spanish recipes</strong>, the chef will tell you stories about those dishes and why food plays a key role in Spanish life. Questions are always welcome, whatever the subject, as the goal is to have fun while immersing yourself in Spanish culture.</p>
		<div class="row justify-content-center">
			<div class="col-lg-10 col-xl-6">
				<figure class="text-center">
					<img data-src="/images/online-details-01.jpg" class="lazyload img-fluid mx-auto d-block" alt="front view">
					<figcaption class="figure-caption">Streamed from a clean, bright kitchen, to focus on what's important</figcaption>
				</figure>
			</div>
			<div class="col-lg-10 col-xl-6">
				<figure class="text-center">
					<img data-src="/images/online-details-02.jpg" class="lazyload img-fluid mx-auto d-block" alt="close-up view">
					<figcaption class="figure-caption">Switch between views at any time so you don't miss any details</figcaption>
				</figure>
			</div>
		</div>
		<h3>Classes</h3>
		<p>We have two classes, offered several times a day to <strong>fit different time zones</strong>. Choose the option and time that best suits your schedule.</p>
		<div class="row justify-content-center">
			<div class="col-sm-6">
				<div class="box all-clickable orange-on-hover">
					<a href="/online-virtual-cooking-classes/paella"></a>
          <img class="img-fluid lazyload" title="the paella class" alt="online classes" data-src="/images/online-menu-02.jpg" />    
					<div class="justify-content-center text-center">
						<h2>Authentic Paella</h2>
						<p><strong>Mixed Paella</strong></p>
						<p><small>Certainly, the most famous Spanish dish, with rice, seafood and chicken.</small></p>
						<p><strong>Catalan Cream</strong></p>
						<p><small>The ubiquituous custard with a Mediterranean touch. A must in Barcelona.</small></p>
						<br/>
 					</div>
				</div>
			</div>
			<div class="col-sm-6 ">
				<div class="box all-clickable orange-on-hover">
					<a href="/online-virtual-cooking-classes/spanish-classic-recipes"></a>
          <img class="img-fluid lazyload" title="classic recipes" alt="online classes" data-src="/images/online-menu-01.jpg" />    
					<div class="justify-content-center text-center">
						<h2>Selected Spanish Recipes</h2>
						<p><strong>Andalusian-style Eggplant with Salmorejo</strong></p>
						<p><small>Renowned tapa from Andalusia, served with Salmorejo, another staple in Sothern Spain.</small></p>
						<p><strong>Stuffed Piquillo Peppers</strong></p>
						<p><small>Discover these peppers from Navarra (Northern Spain), in this recipe stuffed with meat.</small></p>
						<br/>
					</div>
				</div>
			</div>

		</div>

		<p>Both options are easily adaptable to any dietary requirement (vegan, gluten-free, dairy-free,...). Just let us know when you contact us.</p>

		<h3>How it works</h3>
		<p>We use <strong>Zoom app</strong> to stream the classes, so you'll need an account on this App (it's free).</p>
		<p>We have selected recipes that don't require rare ingredients, special set-up, or above-average culinary skills. Easy to find, easy to make, ready to eat.</p>
		<p>When you sign up, you receive a booking confirmation email with:</p>
		<ul style="padding-left: 1rem;">
			<li>Confirmed date and time of the class (in your local time).</li>
			<li><strong>Class Handbook</strong>, a file including:</li>
			<ul style="padding-left: 1rem;">
					<li>Recipes.</li>
					<li>Grocery list, with alternative ingredients in case you can't find them or you have dietary requirements.</li>
					<li>Kitchenware checklist, to make sure you have everything at hand during the class.</li>
					<li>Technical guide to get things ready before the class (Zoom instructions, kitchen set-up...).</li>
				</ul>
		</ul>
		<p>Two days before the class, you receive a <strong>Zoom link</strong> to connect to the videocall.</p>

		<p>The dishes are meant to be eaten after class, but we'll show you ways to store and reheat them later. Recipes are designed for 2 servings, but can be doubled easily. Ask about cuantities if you are cooking for more. </p>

		<p>We recommend to attend in groups of two to get more fun as you share tasks, moreover if you are cooking for a bigger party.</p>

		<h3>Gift Certificates</h3>
		<p>Our classes are a memorable gift for foodies who are always looking for new flavors. You can buy a gift certificate, valid for 1 year, and we will send you a printable certificate. Email us (<a href="mailto:info@cookingpoint.es">info@cookingpoint.es</a>) or use the contact form below with your friend's name and dedication.</p>

		<div class="row justify-content-center">
			<div class="col-lg-10 col-xl-7">
				<figure class="text-center">
					<img data-src="/images/gift-certificate.jpg" class="lazyload img-fluid mx-auto d-block" alt="gift certificate">
					<figcaption class="figure-caption">Gift Certificate Mockup</figcaption>
				</figure>
			</div>
		</div>

		<h3>Private classes</h3>

		<p>Surprise your family and friends organizing a <strong>cooking party</strong> and give family video calling a boost. Kids will love it too, as there are always tasks for them in class.</p>
		<p>How about an <strong>online team building</strong> event? where coworkers show off their culinary skills while having a break from working from home.</p>
		<p>Or what about a distinct <strong>extracurricular activity</strong> to improve high school or college remote learning resources?</p>
		<p>Live online classes open a new world of opportunities, don't hesitate to share your ideas and we'll do our best to make them come true. Please, use the fill-in form below.</p>



		<h3>Inquries</h3>
		<p>For gift certificates, private classes or any other enquiry, please send us a note. We'll reply within 24 hours:</p>
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
	</div>
</div>

		<div class="d-block d-md-none">
			<div class="book-now-bottom all-clickable"><a href="/booking?onlineclass">Book Now</a></div>
		</div>
		<div class="d-none d-md-block">
			<div class="book-now-right all-clickable"><a href="/booking?onlineclass">Book Now</a></div>
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
