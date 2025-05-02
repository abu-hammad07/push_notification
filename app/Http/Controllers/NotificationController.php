<?php
namespace App\Http\Controllers;

use App\Models\NotificationKey;
use Illuminate\Http\Request;
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

class NotificationController extends Controller
{
    public function index()
    {
        $key = NotificationKey::first();
        return view('notifications.form', compact('key'));
    }

    public function storeKeys(Request $request)
    {
        $keys = $request->validate([
            'vapid_public_key' => 'required|string',
            'vapid_private_key' => 'required|string',
        ]);

        NotificationKey::updateOrCreate(
            ['id' => 1],
            $keys
        );

        return redirect()->back()->with('success', 'Notification keys saved successfully');
    }

    public function send(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'url' => 'required|url',
        ]);

        $key = NotificationKey::first();
        if (!$key) {
            return redirect()->back()->with('error', 'No notification keys found');
        }

        $auth = [
            'VAPID' => [
                'subject' => 'mailto:example@yourdomain.com',
                'publicKey' => $key->vapid_public_key,
                'privateKey' => $key->vapid_private_key,
            ],
        ];

        $webPush = new WebPush($auth);

        // In a real application, you would have stored subscriptions
        // For this example, we'll assume we have a subscription
        $subscription = Subscription::create([
            // Add your subscription data here
            // This would typically come from the client-side
            'endpoint' => '',
            'keys' => [
                'p256dh' => '',
                'auth' => ''
            ]
        ]);

        $webPush->queueNotification(
            $subscription,
            json_encode([
                'title' => $data['title'],
                'body' => $data['body'],
                'url' => $data['url']
            ])
        );

        foreach ($webPush->flush() as $report) {
            if (!$report->isSuccess()) {
                return redirect()->back()->with('error', 'Failed to send notification');
            }
        }

        return redirect()->back()->with('success', 'Notification sent successfully');
    }
}
