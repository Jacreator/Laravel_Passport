@component('mail::message')
# Introduction

This will take you to Facebook page

@component('mail::button', ['url' => 'facebook.com'])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
