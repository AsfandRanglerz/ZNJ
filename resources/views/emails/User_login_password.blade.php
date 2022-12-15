@component('mail::message')
# Introduction

{{ $data['password'] }}

{{ $data['email'] }}


Thanks,<br>
{{ config('app.name') }}
@endcomponent
