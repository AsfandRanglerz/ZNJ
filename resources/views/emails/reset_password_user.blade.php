@component('mail::message')
# Introduction

The body of your message.

{{$otp}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
