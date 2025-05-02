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

    <script>
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
    </script>

</body>

</html>
