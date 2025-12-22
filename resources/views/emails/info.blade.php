<!DOCTYPE html>
<html>
<head>
    <title>Bank Account Details</title>
</head>
<body>
<h1>Hello {{ $user->name }},</h1>

<p>Your bank account has been created successfully. Here are your details:</p>

<ul>
    <li><strong>Account Number:</strong> {{ $account->account_number }}</li>
    <li><strong>Temporary Password:</strong> {{ $tempPassword }}</li>
    <li><strong>Verification Code:</strong> {{ $otp }}</li>
</ul>

<p>Please log in and change your password immediately.</p>

<p>Thank you,</p>
<p>Your Bank</p>
</body>
</html>
