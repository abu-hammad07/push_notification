<?php

namespace App\Http\Controllers;

use App\Models\PushNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;

class PushNotificationController extends Controller
{


    public function saveSubscription(Request $request)
    {
        try {
            // Use $request->input('sub') for JSON payloads
            // $subscription = $request->input('sub');

            $item = new PushNotification();
            // $item->subscription = json_encode($request->sub);
            $item->subscription = $request->sub;
            $item->save();

            return response()->json([
                'message' => 'Subscription saved successfully.'
            ], 200);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Subscription Save Error: ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to save subscription',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // public function sendNotification(Request $request)
    // {
    //     $auth = [
    //         'VAPID' => [
    //             'subject' => 'https://flashyourvoicepushnotification.test/',
    //             'publicKey' => 'BI7RpI6B2Fnmh2tFxcEG8O0-Elg84XfaKQPJJI4PpElz2Ulxmbt7JG7EC3uy3O2xsy_LWZFV3Is1H13mmVLPvVg', // (recommended) uncompressed public key P-256 encoded in Base64-URL
    //             'privateKey' => 'vRujaqgcWuphJh50YycbHCbvX2844S9YZpFbt7q795w', // (recommended) in fact the secret multiplier of the private key encoded in Base64-URL
    //         ],
    //     ];

    //     $webPush = new WebPush($auth);

    //     $payload = json_encode([
    //         'title' => $request->title,
    //         'body' => $request->body,
    //         'url' => $request->url,
    //     ]);
    //     // dd($payload);

    //     $notifications = PushNotification::all();
    //     // dd($notifications);


    //     foreach ($notifications as $notification) {
    //         $webPush->sendOneNotification(
    //             Subscription::create($notification->subscription),
    //             $payload,
    //             ['TTL' => 5000]
    //         );
    //     }

    //     return response()->json(['message' => 'Push notifications sent.']);
    // }


    public function sendNotification(Request $request)
    {
        $auth = [
            'VAPID' => [
                'subject' => 'https://flashyourvoicepushnotification.test/',
                'publicKey' => 'YOUR_PUBLIC_KEY',
                'privateKey' => 'YOUR_PRIVATE_KEY',
            ],
        ];

        $webPush = new WebPush($auth);

        $payload = json_encode([
            'title' => $request->title,
            'body' => $request->body,
            'url' => $request->url,
        ]);

        $notifications = PushNotification::all(); // Assuming this model holds subscriptions

        foreach ($notifications as $notification) {
            $subscription = Subscription::create($notification->subscription); // Make sure $notification->subscription is a valid array

            $webPush->sendOneNotification(
                $subscription,
                $payload,
                ['TTL' => 5000]
            );
        }

        return response()->json(['message' => 'Push notifications sent.']);
    }


    // public function sendNotification(Request $request)
    // {

    //     $auth = [
    //         'VAPID' => [
    //             'subject' => 'https://flashyourvoicepushnotification.test/', // can be a mailto: or your website address
    //             'publicKey' => 'BI7RpI6B2Fnmh2tFxcEG8O0-Elg84XfaKQPJJI4PpElz2Ulxmbt7JG7EC3uy3O2xsy_LWZFV3Is1H13mmVLPvVg', // (recommended) uncompressed public key P-256 encoded in Base64-URL
    //             'privateKey' => 'vRujaqgcWuphJh50YycbHCbvX2844S9YZpFbt7q795w', // (recommended) in fact the secret multiplier of the private key encoded in Base64-URL
    //         ],
    //     ];

    //     $webPush = new WebPush($auth);

    //     $payload = json_encode([
    //         'title' => $request->title,
    //         'body' => $request->body,
    //         'url' => $request->url,
    //     ]);

    //     $notifications = PushNotification::all();

    //     foreach ($notifications as $notification) {
    //         $webPush->sendOneNotification(
    //             Subscription::create($notification->subscription),
    //             $payload,
    //             ['TTL' => 5000]
    //         );
    //     }
    // }
}
