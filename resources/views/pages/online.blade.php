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
				<li>Learn at home traditional Spanish tapas</li>
				<li>Schedules adapted to your time zone</li>
				<li>Live class in English</li>
				<li>€40 adult / €25 children (5-12 year old)</li>
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
		<p>As you cook <strong>Spanish delicious recipes</strong>, the chef will tell you stories about those dishes and why food plays a key role in Spanish life. Questions are always welcome, whatever the subject, as the goal is to have fun while immersing yourself in Spanish culture.</p>
		<div class="row justify-content-center">
			<div class="col-lg-10 col-xl-6">
				<figure class="text-center">
					<img data-src="/images/online-details-01.jpg" class="lazyload img-fluid mx-auto d-block" alt="front view">
					<figcaption class="figure-caption">Broadcasted from a clean, bright kitchen, to focus on what's important</figcaption>
				</figure>
			</div>
			<div class="col-lg-10 col-xl-6">
				<figure class="text-center">
					<img data-src="/images/online-details-02.jpg" class="lazyload img-fluid mx-auto d-block" alt="close-up view">
					<figcaption class="figure-caption">Switch at any time to close-up view so as not to miss any details</figcaption>
				</figure>
			</div>
		</div>
		<h3>Menus</h3>
		<p>The class is offered several times a day to <strong>fit different time zones</strong>. Please carefully choose the menu and time that best fits your schedule. We have 3 classes a day, Monday through Saturday.</p>
		<div class="row justify-content-center">
			<div class="col-sm-6 ">
				<div class="pill">
					<div class="justify-content-center text-center">
						<h4>SPANISH SELECTION</h4>
						<p><strong>Berenjena a la Andaluza con Salmorejo</strong></p>
						<p><small>The art of frying along with a magical tomato puree.</small></p>
						<p><strong>Pimientos rellenos de carne</strong></p>
						<p><small>Discover the genuine piquillo peppers, today stuffed with meat.</small></p>
						<br/>
						<div class="btn btn-primary"><a href="/booking?onlineclass">Book</a></div>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="pill">
					<div class="justify-content-center text-center">
						<h4>AUTHENTIC PAELLA</h4>
						<p><strong>Paella mixta</strong></p>
						<p><small>Unquestionably, the most famous Spanish dish, with rice, seafood and chicken.</small></p>
						<p><strong>Ali-oli</strong></p>
						<p><small>Garlic sauce, great friend of paella.</small></p>
						<br/>
						<div class="btn btn-primary"><a href="/booking?onlineclass">Book</a></div>
					</div>
				</div>
			</div>
		</div>
		<p>Both options are easily adaptable to any dietary requirement without major impact (vegan, gluten-free, dairy-free,...). Just let us know when you contact us.</p>
		<div class="row justify-content-center">
			<div class="col-lg-10 col-xl-6">
				<figure class="text-center">
					<img data-src="/images/online-menu-01.jpg" class="lazyload img-fluid mx-auto d-block" alt="garlic shrimp">
					<figcaption class="figure-caption">Garlic Shrimp</figcaption>
				</figure>
			</div>
			<div class="col-lg-10 col-xl-6">
				<figure class="text-center">
					<img data-src="/images/online-menu-02.jpg" class="lazyload img-fluid mx-auto d-block" alt="mixed">
					<figcaption class="figure-caption">Mixed Paella</figcaption>
				</figure>
			</div>
		</div>
		<h3>How it works</h3>
		<p>We use <strong>Zoom app</strong> to broadcast the classes, so you'll need an account on this App (it's free).</p>
		<p>We have selected representative recipes that do not require weird ingredients, special set-up, or above-average culinary skills. Easy to find, easy to make, ready to eat.</p>
		<p>Upon sign up, you'll receive an email with:</p>
		<ul>
			<li>Schedule of the class in your local time.</li>
			<li>Zoom link to join the video call.</li>
			<li>Recipes.</li>
			<li><strong>Grocery list</strong>, with alternative ingredients in case they are hard to find or you have special dietary requirements.</li>
			<li>Kitchenware and utensils checklist, to make sure you have everything at hand during the class.</li>
			<li>Guide to get technical things ready before the class (Zoom stuff,...).</li>
		</ul>
		<p>The dishes are meant to be eaten after class, but we'll show you ways to store and reheat them later.</p>

<!-- 		<h3>Schedules</h3>
		<p>The class is offered several times a day to <strong>fit different time zones</strong>. Please carefully choose the option that best fits your schedule. We have 3 classes a day, Monday through Saturday:</p>
		<ul>
			<li>11:00 AM Madrid time: Targeted to <strong>European</strong> (10:00 AM in UK) and <strong>Asia/Pacific countries</strong> (7:00 PM in Australia East Coast).</li>
			<li>8:00 PM Madrid time: Targeted to <strong>US & Canada West Coast</strong> (11:00 AM Pacific Time).</li>
			<li>11:00 PM Madrid time: Targeted to <strong>US & Canada East Coast</strong> (5:00 PM Eastern Time).</li>
		</ul>
		<div class="row justify-content-center">
			<div class="col-lg-10 col-xl-8">
				<div class="pill">
					<table>
						<tbody>
							<tr>
								<td><strong>Your local time:</strong></td>
								<td style='padding-left:1rem'><span id="localTime"></span></td>
							</tr>
							<tr>
								<td><strong>Time in Madrid:</strong></td>
								<td style='padding-left:1rem'><span id="madridTime"></span></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div> -->

		<h3>Fun Anywhere</h3>
		<p>Surprise your family and friends organizing a <strong>cooking party</strong> and give family video calling a boost. Kids will love it too, as there are always tasks for them in class.</p>
		<p>Also, our classes can be fun <strong>gift certificate</strong> for foodies who are always looking for new flavors.</p>
		<p>How about an <strong>online team building</strong> event? where coworkers show off their culinary skills while having a break from working from home.</p>
		<p>Or what about a fun <strong>extracurricular activity</strong> to improve high school or college remote learning resources?</p>
		<p>Live online classes open a new world of opportunities, don't hesitate to share your ideas and we'll do our best to make them come true.</p>
		<h3>Inquiries / Gift Certificates</h3>
		<p>If you are thinking about gift certificates or about organizing a private class, send us a note. We'll reply within 24 hours:</p>
		<div class="row">
			<div class="offset-md-1 col-md-10 col-sm-10">
				<table style="width: 100%">
					<tbody>
						<tr>
							<td class="font-weight-bold">
								Name :
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
								E-mail <span class="text-danger">*</span> :
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
								Message:
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
<script defer type="text/javascript">
showTime()

function showTime () {
  const date = new Date()
  console.log(navigator.language)
  let options = { dateStyle: 'long', timeStyle: 'full' };
  const localTime = date.toLocaleString("en-US", options)
  options.timeZone = 'Europe/Madrid'
  const madridTime = date.toLocaleString("en-US", options)
  document.getElementById('localTime').innerHTML = localTime
  document.getElementById('madridTime').innerHTML = madridTime
  setTimeout(showTime, 1000)
}
</script>

<script defer src="{{ mix('/js/contactonlineclasses.js') }}"></script>
@stop
