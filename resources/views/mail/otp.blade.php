<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #007bff;
            font-size: 24px;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        .otp {
            display: inline-block;
            padding: 10px 20px;
            font-size: 20px;
            color: #fff;
            background-color: #007bff;
            border-radius: 5px;
            text-decoration: none;
        }

        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Hi👋🏻, {{ Auth::user()->firstName }}</h1>
        <p>Welcome to the Laravel App. To complete your verification process, please use the following OTP code:</p>
        <p><strong class="otp">{{ $otp }}</strong></p>
        <p>This code will expire in 1 minutes. If you did not request this OTP, please ignore this email.</p>
        <div class="footer">
            <p>Thank you for using our application.</p>
            <p>Best regards,<br>The Developer Team </p>
        </div>
        <p class="note">Please note: This is an automated email. Do not reply directly to this message.</p>
    </div>
</body>

</html>
