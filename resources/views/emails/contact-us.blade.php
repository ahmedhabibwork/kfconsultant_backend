<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Us</title>
</head>

<body
    style="font-family: Arial, sans-serif; line-height: 1.6; text-align: left; direction: ltr;">
    <h1>{{ $data['subject'] }}</h1>

    <ul>
        <li>{{ __('Name') }}: {{ $data['name'] }}</li>
        <li>{{ __('Email') }}: {{ $data['email'] }}</li>
        <li>{{ __('Phone') }}: {{ $data['phone']}}</li>
        <li>{{ __('Subject') }}: {{ $data['subject']}}</li>
        <li>{{ __('Message') }}: {{ $data['notes']}}</li>
    </ul>

    <p>{{ __('Regards,') }}</p>
    <p>{{ __('KFconsultant') }}</p>
    
</body>
</html>
