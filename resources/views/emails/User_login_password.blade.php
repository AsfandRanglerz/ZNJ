@component('mail::message')
# Introduction

{{ $messages['password'] }}

{{ $messages['email'] }}


Thanks,<br>
{{ config('app.name') }}
@endcomponent
