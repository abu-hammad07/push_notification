<!DOCTYPE html>
<html>
<head>
    <title>Notification System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Notification System</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Enable Notification Form -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold mb-4">Enable Notifications</h2>
            <form action="{{ route('notifications.storeKeys') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700">VAPID Public Key</label>
                    <input type="text" name="vapid_public_key" value="{{ $key->vapid_public_key ?? '' }}" class="w-full border rounded p-2" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">VAPID Private Key</label>
                    <input type="text" name="vapid_private_key" value="{{ $key->vapid_private_key ?? '' }}" class="w-full border rounded p-2" required>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Enable Notifications</button>
            </form>
        </div>

        <!-- Send Notification Form -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Send Notification</h2>
            <form action="{{ route('notifications.send') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700">Title</label>
                    <input type="text" name="title" class="w-full border rounded p-2" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Body</label>
                    <textarea name="body" class="w-full border rounded p-2" required></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">URL</label>
                    <input type="url" name="url" class="w-full border rounded p-2" required>
                </div>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Send Notification</button>
            </form>
        </div>
    </div>

    <script>
        // For demonstration: This would typically be more complex
        async function enableNotifications() {
            if ('serviceWorker' in navigator && 'PushManager' in window) {
                try {
                    const registration = await navigator.serviceWorker.register('/service-worker.js');
                    const subscription = await registration.pushManager.subscribe({
                        userVisibleOnly: true,
                        applicationServerKey: '{{ $key->vapid_public_key ?? "" }}'
                    });

                    // In a real application, send subscription to server
                    console.log('Push subscription:', subscription);
                } catch (error) {
                    console.error('Error enabling notifications:', error);
                }
            }
        }
    </script>
</body>
</html>
