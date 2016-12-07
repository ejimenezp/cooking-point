<?php

// require_once dirname( __FILE__ ) . '/vendor/autoload.php';

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */

namespace App\Http\Controllers\Legacy;

use Log;
use Google_Client;
use Google_Service_Gmail;
use Google_Service_Gmail_Message;
use Illuminate\Support\Facades\Storage;
use Booking;

class LegacyMail {

	static function set_booking_data($bkg, $filename)
	{
		$activityDate = new DateTime($bkg->calendarevent->date);
		$legibleDate = $activityDate->format('l, d F Y');
		
		$arr = explode(' ',trim($bkg->name));
		
		switch ($bkg->status_major) {
			case 'PENDING':
				$status = "Payment Required";
				break;
			case 'PAID':
				$status = "Paid";
				break;
			case 'CANCELLED':
				$status = "Cancelled";
				break;
			default:
				$status = "Contact Us";
			}
				
		// build html from template
		$html = Storage::get($filename);
		
		// $html = str_replace('CP_EMAILTEXT', nl2br(stripslashes($r['emailText'])), $html); // only for PE
		$html = str_replace('CP_HASH', $bkg->hash, $html);
		$html = str_replace('CP_NAME', stripslashes($bkg->name), $html);
		$html = str_replace('CP_FIRSTNAME', stripslashes($arr[0]), $html);
		$html = str_replace('CP_EMAIL', $bkg->email, $html);
		$html = str_replace('CP_PHONE', $bkg->phone, $html);
		$html = str_replace('CP_ACTIVITY', $bkg->calendarevent->short_description, $html);
		$html = str_replace('CP_ACTDATE', $legibleDate, $html);
		$html = str_replace('CP_NUMADULTS', $bkg->adult, $html);
		$html = str_replace('CP_NUMCHILDREN', $bkg->child, $html);
		$html = str_replace('CP_PRICE', $bkg->price, $html);
		$html = str_replace('CP_STATUS', $status, $html);
		$html = str_replace('CP_FOODRESTRICTIONS', nl2br(stripslashes($bkg->food_requirements)), $html);
		$html = str_replace('CP_COMMENTS', nl2br(stripslashes($bkg->comments)), $html);
		$html = str_replace('APP_URL', config('cookingpoint.env.app_url'), $html);
		
		return $html;
		
	}

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



	static function mail_to_user($bkg, $mail_template)
	{
		
		$html_body = self::set_booking_data($bkg, $mail_template . ".html");
		$txt_body = self::set_booking_data($bkg, $mail_template . ".txt");
		
		// building mime message
		$envelope["from"]= 'Cooking Point <info@cookingpoint.es>';
		$envelope["to"]  = $$bkg->email;
		$envelope["subject"]  = Storage::get($mail_template . ".subject.txt");
		
		$part1["type"] = TYPEMULTIPART;
		$part1["subtype"] = "alternative";
		
		$part2["type"] = TYPETEXT;
		$part2["subtype"] = "plain";
		$part2["description"] = "Cooking Point Booking Details";
		$part2["charset"] ="utf-8";
		$part2["contents.data"] = $txt_body;
		
		$part3["type"] = TYPETEXT;
		$part3["subtype"] = "html";
		$part3["description"] = "Cooking Point Booking Details";
		$part3["charset"] ="utf-8";
		$part3["contents.data"] = $html_body;
		
		$body[1] = $part1;
		$body[2] = $part2;
		$body[3] = $part3;
		
		$mime_message = imap_mail_compose($envelope, $body);
		
		// localhost version
		// Log::info("mail sent to $r[email]. Subject: {$envelope["subject"]}. Text:");
		// Log::info($txt_body);
		// return;

		// Make the call to the gmail API
		
		try
		{
			$client = self::getClient();
			$service = new Google_Service_Gmail($client);

			$encoded = rtrim(strtr(base64_encode($mime_message), '+/', '-_'), '=');
			$userId = 'me';
			$message = new Google_Service_Gmail_Message();
			$message->setRaw($encoded);
			$result = $service->users_messages->send($userId, $message);
			// Log::info($mime_message);

			// LegacyModel::to_bookings_log($bkg->hash,'EMAIL', $details);
							
		} 
		catch (Exception $e) 
		{
			error_log('An error occurred: ' . $e->getMessage());
		}
		

	}


	static function mail_to_admin($bkg, $from_string, $to_string, $subject_string, $mail_template)
	{

		$mail_body = self::set_booking_data($bkg, $mail_template);

		// localhost version
		//error_log("mail sent to $r[email]. Text:");
		//error_log($mail_body);
		//return;

		// building mime message
		$envelope["from"]= $from_string . '<info@cookingpoint.es>';
		$envelope["to"]  = $to_string;
		$envelope["subject"]  = $subject_string;

		$part1["type"] = TYPEMULTIPART;
		$part1["subtype"] = "mixed";

		$part2["type"] = TYPETEXT;
		$part2["subtype"] = "html";
		$part2["description"] = "Payment Notice";
		$part2["charset"] ="utf-8";
		$part2["contents.data"] = $mail_body;

		$body[1] = $part1;
		$body[2] = $part2;

		$mime_message = imap_mail_compose($envelope, $body);


		try
		{
			$client = self::getClient();
			$service = new Google_Service_Gmail($client);

			$encoded = rtrim(strtr(base64_encode($mime_message), '+/', '-_'), '=');
			$userId = 'me';
			$message = new Google_Service_Gmail_Message();
			$message->setRaw($encoded);
			$result = $service->users_messages->send($userId, $message);
			// Log::info($mime_message);
							
		} 
		catch (Exception $e) 
		{
			error_log('An error occurred: ' . $e->getMessage());
		}
	}	
}