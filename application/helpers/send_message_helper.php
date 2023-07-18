<?php

if (!function_exists('send_message_whatsapp')) {

	function send_message_whatsapp($notlp, $message, $token = 'y74C0EyuopvmMCTzvTg0') {
		$curl = curl_init();
		$config = [
			CURLOPT_URL => 'https://api.fonnte.com/send',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => [
				'target' => "$notlp",
				'message' => "$message", 
				'delay' => '5',
				'countryCode' => '62', //optional
			],
			CURLOPT_HTTPHEADER => [
				"Authorization: $token" //change TOKEN to your actual token
			],
		];

		curl_setopt_array($curl, $config);

		$response = curl_exec($curl);
		curl_close($curl);
		return $response;
	}
}