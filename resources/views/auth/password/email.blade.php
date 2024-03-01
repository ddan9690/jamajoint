<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyberSpace - Forget Password Email</title>
</head>
<body>
    <div style="text-align: center; padding: 20px; background-color: #f4f4f4;">
        <h1 style="color: #333333; font-family: 'Arial', sans-serif;">CyberSpace</h1>


        <p style="font-size: 16px; color: #333333; font-family: 'Arial', sans-serif;">You can reset your password using the link below:</p>

        <p style="margin: 20px 0;">
            <a href="{{ route('reset.password.get', $token) }}" style="display: inline-block; padding: 10px 20px; background-color: #3490dc; color: #ffffff; text-decoration: none; border-radius: 5px; font-family: 'Arial', sans-serif;">Reset Password</a>
        </p>

        <p style="font-size: 16px; color: #333333; font-family: 'Arial', sans-serif;">Regards,</p>
        <p style="font-size: 16px; color: #333333; font-family: 'Arial', sans-serif;">CyberSpace Team</p>
    </div>
</body>
</html>
