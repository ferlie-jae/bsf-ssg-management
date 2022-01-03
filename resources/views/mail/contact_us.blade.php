<!DOCTYPE html>
<html>
<head>
    <title>{{ config('app.name') }}</title>
</head>
<body>
    {{-- <p>
        This is a sample message
    </p> --}}
    <p>
        <b>Name: </b> {{ $data->name }}
    </p>
    <p>
        <b>Email: </b> <a href="mailto:{{ $data->email }}">{{ $data->email }}</a>
    </p>
    <hr>
    <p>
        <b>Message: </b><br>
        {{ $data->message }}
    </p>
</body>
</html>