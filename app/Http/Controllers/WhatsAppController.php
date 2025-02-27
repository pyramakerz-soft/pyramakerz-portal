<?php

namespace App\Http\Controllers;

use Twilio\Rest\Client;

class WhatsAppController extends Controller
{
    public function sendWhatsAppMessage()
    {
        $twilioSid = env('TWILIO_SID');
        $twilioToken = env('TWILIO_AUTH_TOKEN');
        $twilioWhatsAppNumber = env('TWILIO_WHATSAPP_NUMBER');
        $recipientNumber = '+201277875584'; // Replace with the recipient's phone number in WhatsApp format (e.g., "whatsapp:+1234567890")
        $message = "Hello from Twilio WhatsApp API in Laravel! 🚀";

        $twilio = new Client($twilioSid, $twilioToken);

        try {
            $twilio->messages->create(
                $recipientNumber,
                [
                    "from" => $twilioWhatsAppNumber,
                    "body" => $message,
                ]
            );

            return response()->json(['message' => 'WhatsApp message sent successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}