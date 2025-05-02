{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Notification Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        button {
            margin-bottom: 20px;
            padding: 10px 20px;
        }

        form {
            max-width: 400px;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }
    </style>
</head>

<body>

    <button onclick="enableNotification()">Enable Notification</button>

    <form id="notificationForm">
        <label for="title">Title</label>
        <input type="text" id="title" name="title" placeholder="Enter title" required>

        <label for="body">Body</label>
        <input type="text" id="body" name="body" placeholder="Enter body text" required>

        <label for="url">URL</label>
        <input type="text" id="url" name="url" placeholder="Enter URL" required>
    </form>

    <script>
        function enableNotification() {
            if (Notification.permission === "granted") {
                alert("Notifications are already enabled.");
            } else if (Notification.permission !== "denied") {
                Notification.requestPermission().then(permission => {
                    if (permission === "granted") {
                        alert("Notifications enabled!");
                    } else {
                        alert("Notifications denied.");
                    }
                });
            } else {
                alert("Notifications are blocked. Please enable them manually.");
            }
        }
    </script>

</body>

</html> --}}


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

    <button id="enableNotification">Enable Notification</button>

    <form id="notificationForm">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>

        <label for="body">Body:</label>
        <input type="text" id="body" name="body" required>

        <label for="url">URL:</label>
        <input type="url" id="url" name="url" required>

        <button type="submit">Send Notification</button>
    </form>

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
