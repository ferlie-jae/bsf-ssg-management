<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <title>Document</title> --}}
</head>
<body>
    <p>
        This is to confirm that your account has been activated. You may now login to <a href="{{ config('app.url') }}/login">Online SSG Management</a> of Binmaley School of Fisheries using the information below:                                  
    </p>
    <p>
        <ul style="list-style: none">
            <li>
                <b>Username:</b>
                {{ $user->username }}
            </li>
            <li>
                <b>Password:</b>
                {{ $user->temp_password }}
            </li>
        </ul>
    </p>
    <p>
        <i>Temporary password has been made, upon login it's your responsibility to change your account password for you to secure your account.</i>
    </p>
    <p>
        PLEASE PROTECT YOUR ACCOUNT INFORMATION. You assume full responsibility for maintaining the confidentiality of your Username and Password.
    </p>
    <br>
    <p>
        - Binmaley School of Fisheries
    </p>
    <p>
        <i>This is a system-generated email. Please do not reply.</i>
    </p>
</body>
</html>