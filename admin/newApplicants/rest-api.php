<?php
require_once '../../vendor/autoload.php'; // Include the Twilio PHP SDK

use Twilio\Rest\Client;

// Twilio account credentials
$accountSid = 'ACdb104c23fa2c140dbbf8822ff3bac332'; // Replace with your Twilio Account SID
$authToken = '509d6748763c5bb2c08daa23e69e6b29';   // Replace with your Twilio Auth Token

// Instantiate a new Twilio client
$client = new Client($accountSid, $authToken);

try {
    // Make the call
    $call = $client->calls->create(
        '+18638374498', // The destination phone number (recipient)
        '+09483556700', // Your Twilio phone number as Caller ID
        [
            'url' => 'http://demo.twilio.com/docs/voice.xml' // URL for TwiML instructions
        ]
    );

    // Output the Call SID if the call was successful
    echo "Call initiated successfully! Call SID: " . $call->sid;

} catch (Exception $e) {
    // Handle any errors
    echo "Error: " . $e->getMessage();
}
?>
