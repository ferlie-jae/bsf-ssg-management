<!DOCTYPE html>
<html>
<head>
    {{-- <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge"> --}}
    <title>{{ config('app.name') }}</title>
</head>
<body>
    <p>
        Hello {{ $student->first_name }}, you register an student account in <a href="{{ config('app.url') }}" target="_blank">BSF SSG Management</a>.
        Your account is under verification. You'll get notified immediately if your account is verified.
    </p>
    <p>
        These are the information you've been registered:
        <ul style="list-style: none">
            <li>
                <b>First Name:</b>
                {{ $student->first_name }}

            </li>
            <li>
                <b>Last Name:</b>
                {{ $student->last_name }}
            </li>
        </ul>
    </p>
    <p>
        - Binmaley School of Fisheries
    </p>
    <p>
        <i>This is a system-generated email. Please do not reply.</i>
    </p>
</body>
</html>