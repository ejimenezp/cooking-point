@extends('masterlayout')

@section('title', 'Frequently Asked Questions')
@section('description', 'Information about dietary requirements, cancellation policy and more.')

@section('content')


<h1>Frequently Asked Questions</h1>

<h3>In-person Classes</h3>

<dl>
	<dt><strong>I have some dietary requirements, can I book?</strong></dt>
	<dd>Yes, we are ready to deal with most dietary requirements and allergies: vegetarian, no pork, gluten, dairy, seafood allergies... Anyway, don’t forget the cooking is done in pairs. You both need to agree on the alternative option. Also, when you book, please let us know your exact food restrictions.</dd>
</dl>

<dl>
	<dt><strong>What is included in the price?</strong></dt>
	<dd>The price of cooking classes includes taxes, meals, ingredients, drinks, recipe booklet and market visit (if it's part of the class). You just need to be ready to have fun, the rest is up to us.</dd>
	</dl>

<dl>
<dt><strong>How do I pay?</strong></dt>
	<dd>To confirm the booking you will be requested to pay through our bank's payment platform (your card data never reaches our site).</dd>
</dl>

<dl>
	<dt><strong>What is the cancellation policy?</strong></dt>
	<dd>We refund 100% if you cancel up to 24 hours before the event.</dd>
</dl>

<dl>
	<dt><strong>Can we bring children?</strong></dt>
	<dd>Knives, ovens and wine are not a child’s best friend. However, your children are welcome as long as they are accompanied by an adult and attended to throughout.</dd>
</dl>

<dl>
	<dt><strong>I’m traveling alone, can I book?</strong></dt>
	<dd>Of course, but keep in mind that we will probably pair you with a fellow cook. All recipes are written and prepared for two people.</dd>
</dl>

<h3 id="onlineclass">Online Classes</h3>

<dl>
	<dt><strong>How can I recover my booking?</strong></dt>
	<dd>Try find it in your mailbox (search by sender info@cookingpoint.es). Alternatively, go to the <a href="{{ url('/booking') }}">Booking</a> section with the same browser you used to book. Your data should show up, unless you clicked on "New booking" to clear the form.</dd>
</dl>

<dl>
	<dt><strong>Where can I find my Class Handbook?</strong></dt>
	<dd>It comes attached to the booking confirmation email. If you can't locate the email, go to your booking and email it again.</dd>
</dl>

<dl>
	<dt><strong>Can I book for just one person?</strong></dt>
	<dd>Yes, sure, but keep in mind it will be harder, as you have to do all the tasks.</dd>
</dl>

<dl>
	<dt><strong>What is the cancellation policy?</strong></dt>
	<dd>We refund 100% if you cancel up to 48 hours before the class.</dd>
</dl>

<dl>
	<dt><strong>What's included in the price</strong></dt>
	<dd>Price includes attending a live class streamed through a Zoom video call. Ingredients are not included.</dd>
</dl>

<dl>
	<dt><strong>What's the maximum number of participants</strong></dt>
	<dd>For the moment, our classes are really small, with 3-4 parties at the most.</dd>
</dl>

<dl>
	<dt><strong>What kind of pan is suitable for paella cooking?</strong></dt>
	<dd>Regarding the form, you can use any flat, wide pan (paella pan, skillet, frying pan), as the rice should be as shallow as possible. Regarding the size, we recommend a pan around 11" for 2 servings, and around 13" for 4. We advise against using cast iron, as these pans keep the heat too long, making it hard to change their temperature. Non-stick pans are advisable for beginners.</dd>
</dl>

@stop


