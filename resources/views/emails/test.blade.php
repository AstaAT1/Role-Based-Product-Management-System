<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h1>{{ $title }}</h1>

        <p>{{ $body }}</p>

        <hr>

        <p>Salam,<br>{{ config('app.name') }}</p>
    </div>
</body>
</html>
