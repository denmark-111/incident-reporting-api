<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
</head>
<body>
    <h2>Hello {{ $user->name ?? 'User' }},</h2>

    <p>We received a request to reset your password.</p>

    <p>
        Click the button below to reset your password:
    </p>

    <p>
        <a href="{{ $url }}"
           style="display:inline-block;padding:10px 20px;
           background:#2563eb;
           color:white;
           text-decoration:none;
           border-radius:6px;">
            Reset Password
        </a>
    </p>

    <p>
        If you did not request this, you can ignore this email.
    </p>

    <p>This link will expire in 60 minutes.</p>
</body>
</html>