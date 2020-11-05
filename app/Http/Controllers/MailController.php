<?php

// require_once dirname( __FILE__ ) . '/vendor/autoload.php';

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */

namespace App\Http\Controllers;

use Log;
use Swift_Message;
use Swift_Image;
use Swift_Attachment;
use Swift_SmtpTransport;
use Swift_Mailer;
use Google_Client;
use Google_Service_Gmail;
use Google_Service_Gmail_Message;
use Illuminate\Support\Facades\Storage;
use App\Timezone;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonTimeZone;

class MailController {

	static function getClient() {
		$client = new Google_Client();
		$client->setApplicationName('Sends offline mail');
		$client->setScopes("https://www.googleapis.com/auth/gmail.send");
		$client->setAuthConfigFile(storage_path(config('cookingpoint.gmail.client_secret')));
		$client->setAccessType('offline');
		$client->setApprovalPrompt('force');

		// Load previously authorized credentials from a file.
		$credentialsPath = storage_path(config('cookingpoint.gmail.credentials'));
		$refreshPath = storage_path(config('cookingpoint.gmail.refresh'));

		if (file_exists($credentialsPath))
		{
			// error_log($credentialsPath);
			$accessToken = file_get_contents($credentialsPath);
		}
		else
		{
			// Request authorization from the user.
			// error_log( "antes de createAuth");
			$authUrl = $client->createAuthUrl();
			printf("Open the following link in your browser:\n%s\n", $authUrl);
			print 'Enter verification code: ';
			$authCode = trim(fgets(STDIN));

			// Exchange authorization code for an access token.
			$accessToken = $client->authenticate($authCode);

			// Store the credentials to disk.
			if(!file_exists(dirname($credentialsPath)))
			{
				mkdir(dirname($credentialsPath), 0700, true);
			}
			file_put_contents($credentialsPath, json_encode($accessToken));
			printf("Credentials saved to %s\n", $credentialsPath);

			// store refresh token if included 
			$refresh = $accessToken['refresh_token'];
			if (isset($refresh)) {
				if(!file_exists(dirname($refreshPath))) {
					mkdir(dirname($refreshPath), 0700, true);
				}
				file_put_contents($refreshPath, $refresh);
				printf("Refresh token (%s) saved to %s\n", $refresh, $refreshPath);
			}

		}

		$client->setAccessToken($accessToken);

		// Refresh the token if it's expired.
		if ($client->isAccessTokenExpired())
		{
			if (file_exists($refreshPath))
			{
				$storedRefreshToken = file_get_contents($refreshPath);
			}

			$client->fetchAccessTokenWithRefreshToken($storedRefreshToken);
			file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
		}
		return $client;
	}


	static function send_mail($to, $bkg, $mail_template) {
		
		$message = new Swift_Message();
		$message->setFrom(['info@cookingpoint.es' => Storage::get('templates/' . $mail_template . "/from.txt")])
						->setTo([$to])
						->setSubject(self::set_booking_data($bkg, $mail_template . "/subject.txt"))
						->setBody(self::set_booking_data($bkg, $mail_template . "/body.html", $message), 'text/html')
						->addPart(self::set_booking_data($bkg, $mail_template . "/body.txt"), 'text/plain');

		// testing version
		if (env('APP_ENV') != 'production') {
			$transport = (new Swift_SmtpTransport(env('MAIL_HOST'), env('MAIL_PORT')))
			  ->setUsername(env('MAIL_USERNAME'))
			  ->setPassword(env('MAIL_PASSWORD'));
			$mailer = new Swift_Mailer($transport);
			$result = $mailer->send($message);		
			return;		
		}

		// Make the call to the gmail API
		
		try
		{
			$client = self::getClient();
			$service = new Google_Service_Gmail($client);

			$encoded = rtrim(strtr(base64_encode($message->toString()), '+/', '-_'), '=');
			$userId = 'me';
			$message = new Google_Service_Gmail_Message();
			$message->setRaw($encoded);
			$result = $service->users_messages->send($userId, $message);	
		} 
		catch (Exception $e) 
		{
			error_log('An error occurred: ' . $e->getMessage());
		}
	}


	static function set_booking_data($bkg, $filename, $message = null) {

		$activityDate = new Carbon($bkg->calendarevent->date);
		$legibleDate = $activityDate->format('l, d F Y');

		$start_time = Carbon::createFromFormat('H:i:s', $bkg->calendarevent->time);
		$bits = explode(':', $bkg->calendarevent->duration);
		$duration = CarbonInterval::hours($bits[0])->minutes($bits[1]);
		$end_time = (new Carbon($start_time))->add($duration);
		$legibleTime = $start_time->format('g:i A') . ' - ' . $end_time->format('g:i A');

		$TzedActivityDate = new Carbon($bkg->calendarevent->startdateatom);
		$TzedActivityDate->tz(new CarbonTimeZone($bkg->tz));
		$TzedDate = $TzedActivityDate->format('l, d F Y');

		$bits = explode(':', $bkg->calendarevent->duration);
		$duration = CarbonInterval::hours($bits[0])->minutes($bits[1]);
		$end_time = (new Carbon($TzedActivityDate))->add($duration);
		$a = Timezone::where('timezone', $bkg->tz)->first();
		if ($a) {
			$tzName = $a->gmt;
		}else {
			$tzName = '(' . $bkg->tz . ' time)';
		}
		$gmt = ($bkg->onlineclass) ? $tzName : '';
		$TzedTime = $TzedActivityDate->format('g:i A') . ' - ' . $end_time->format('g:i A') . ' ' . $gmt;

		$arr = explode(' ',trim($bkg->name));
		
		switch ($bkg->status) {
			case 'PENDING':
				$status = "Payment Required";
				break;
			case 'PAID':
				$status = "Paid";
				break;
			case 'CANCELED':
				$status = "Canceled";
				break;
			default:
				$status = "Contact Us";
			}
				
		switch ($bkg->source_id) {
			case 5:
				$source = "VIATOR";
				break;
			default:
				$source = "ONLINE";
			}

		// build html from template
		$html = Storage::get('templates/' . $filename);
		
		$html = str_replace('CP_HASH', $bkg->hash, $html);
		$html = str_replace('CP_NAME', stripslashes($bkg->name), $html);
		$html = str_replace('CP_FIRSTNAME', stripslashes($arr[0]), $html);
		$html = str_replace('CP_EMAIL', $bkg->email, $html);
		$html = str_replace('CP_PHONE', $bkg->phone, $html);
		$html = str_replace('CP_TYPE', $bkg->calendarevent->type, $html);
		$html = str_replace('CP_CLASS', $bkg->calendarevent->short_description, $html);
		$html = str_replace('CP_RAWDATE', $bkg->calendarevent->date, $html);
		$html = str_replace('CP_REGISTERED', $bkg->calendarevent->registered, $html);
		$html = str_replace('CP_DATE', $legibleDate, $html);
		$html = str_replace('CP_TIME', $legibleTime, $html);
		$html = str_replace('CP_TZED_DATE', $TzedDate, $html);
		$html = str_replace('CP_TZED_TIME', $TzedTime, $html);
		$html = str_replace('CP_ADULT', $bkg->adult, $html);
		$html = str_replace('CP_CHILD', $bkg->child, $html);
		$html = str_replace('CP_PRICE', ($bkg->hide_price ? '--.--' : $bkg->price), $html);
		$html = str_replace('CP_STATUS', $status, $html);
		$html = str_replace('CP_PAYMENTDATE', ($bkg->payment_date ? $bkg->payment_date : '-'), $html);
		$html = str_replace('CP_SOURCE', $source, $html);
		$html = str_replace('CP_COOK', $bkg->calendarevent->staff->name, $html);
		$html = str_replace('CP_LOCATOR', $bkg->locator, $html);
		$html = str_replace('CP_FOODREQUIREMENTS', nl2br(stripslashes($bkg->food_requirements)), $html);
		$html = str_replace('CP_COMMENTS', nl2br(stripslashes($bkg->comments)), $html);
		$html = str_replace('APP_URL', config('app.url'), $html);
		$html = str_replace('CP_INVITATION', $bkg->calendarevent->invitation_link, $html);

		if ($message && $bkg->calendarevent->eventtype->attachments) {
			$attachments = explode(',', $bkg->calendarevent->eventtype->attachments);
			$mimetype_set = ['image/jpeg', 'image/png','image/gif','image/svg+xml'];

			for ($i = 0; $i < sizeof($attachments); $i++) {

				$filefullpath = base_path() . $attachments[$i];

				if (in_array(mime_content_type($filefullpath), $mimetype_set)) {
					$html = str_replace('CP_ATTACHMENT['.$i.']', $message->embed(Swift_Image::fromPath(base_path() . $attachments[$i])), $html);					
				} else {
					$html = str_replace('CP_ATTACHMENT['.$i.']', $message->attach(Swift_Attachment::fromPath(base_path() . $attachments[$i])), $html);
				}
			}
		}

		return $html;		
	}

}
