@component('mail::message')
# Introduction

{{ $message['password'] }}

{{ $message['email'] }}


Thanks,<br>
{{ config('app.name') }}
@endcomponent
