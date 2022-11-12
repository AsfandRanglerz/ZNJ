@component('mail::message')
<img src="{{ asset('public/admin/assets/img/logo.png')}}" alt="ZNJ Logo" style="max-width: 17%; left:50%; margin-bottom: 23px;">

<h1>Forget Password</h1>



You are receiving this email because we received a password reset request for your account.

<strong style="max-width: 10%; left:50%; margin-bottom: 10px;font-size:25px;">{{ $otp }}</strong>

This password reset OTP will expire in 60 minutes.

If you did not request a password reset, no further action is required.


Thanks,<br>

{{ config('app.name') }}

@endcomponent
