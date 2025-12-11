<!-- resources/views/emails/verification_code.blade.php -->
<h2>Hi {{ $user->name ?? 'no username' }},</h2>
<p>Your verification code is:</p>
<h1>{{ $user->verification_code ?? 'no data found' }}</h1>
<p>Please enter this code in the verification page to complete your registration.</p>
