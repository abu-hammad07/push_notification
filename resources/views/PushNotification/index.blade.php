<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Notification Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 400px;
            margin: 50px auto;
        }

        button,
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }

        label {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <button id="enableNotification" onclick="askForNotification()">Enable Notification</button>

    {{-- <form id="notificationForm">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>

        <label for="body">Body:</label>
        <input type="text" id="body" name="body" required>

        <label for="url">URL:</label>
        <input type="url" id="url" name="url" required>

        <button type="submit">Send Notification</button>
    </form> --}}


    <label for="title">Title:</label>
    <input type="text" id="title" name="title" required>

    <label for="body">Body:</label>
    <input type="text" id="body" name="body" required></input>

    <label for="url">URL:</label>
    <input type="url" id="url" name="url" required>

    <button type="button" onclick="sendNotification()">Send Notification</button>





    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        navigator.serviceWorker.register("{{ asset('service-worker.js') }}");

        function askForNotification() {
            Notification.requestPermission().then(permission => {
                if (permission === 'granted') {
                    navigator.serviceWorker.ready.then(sw => {

                        sw.pushManager.subscribe({
                            userVisibleOnly: true,
                            applicationServerKey: "BI7RpI6B2Fnmh2tFxcEG8O0-Elg84XfaKQPJJI4PpElz2Ulxmbt7JG7EC3uy3O2xsy_LWZFV3Is1H13mmVLPvVg"
                        }).then((subcription) => {
                            console.log(subcription);
                            saveSub(JSON.stringify(subcription));
                        })

                    })
                }
            })
        }

        function saveSub(sub) {
            fetch('{{ URL('save-push-notification-sub') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        sub: sub
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                })
                .catch(error => {
                    console.error('Error saving subscription:', error);
                });
        }


        function sendNotification() {
            $.ajax({
                type: 'POST',
                url: '{{ url('send-push-notification') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    title: $('#title').val(),
                    body: $('#body').val(),
                    url: $('#url').val()
                },
                success: function(response) {
                    console.log(response);
                    alert('Notification sent successfully!');
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Something went wrong.');
                }
            });
        }

        // "{\"keys\":{\"p256dh\":\"BM_o5P9iIb1cvqTfell2I_TkwEo9g-DVxlxRGVycRyFmVmWY3AUCvzkt9yt2qdM6vweldqelYnYRV53ViSxRzlk\",\"auth\":\"yRd8Ig54raVYGaMfJDn02g\"}}"


        // $('#notificationForm').on('submit', function(event) {
        //     event.preventDefault();

        //     $.ajax({
        //         type: 'POST',
        //         url: '{{ url('send-push-notification') }}',
        //         data: {
        //             _token: '{{ csrf_token() }}',
        //             title: $('#title').val(),
        //             body: $('#body').val(),
        //             url: $('#url').val()
        //         },
        //         success: function(response) {
        //             console.log(response);
        //             alert('Notification sent successfully!');
        //         },
        //         error: function(xhr) {
        //             console.error(xhr.responseText);
        //             alert('Failed to send notification.');
        //         }
        //     });
        // });
    </script>







    {{-- <script>
        document.getElementById('enableNotification').addEventListener('click', function() {
            Notification.requestPermission().then(permission => {
                alert('Notification permission: ' + permission);
                console.log(permission);
            });
        });

        document.getElementById('notificationForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const title = document.getElementById('title').value;
            const body = document.getElementById('body').value;
            const url = document.getElementById('url').value;

            if (Notification.permission === 'granted') {
                const notification = new Notification(title, {
                    body: body,
                });

                notification.onclick = () => {
                    window.open(url, '_blank');
                };
            } else {
                alert('Please enable notifications first.');
            }
        });
    </script> --}}

</body>

</html>
