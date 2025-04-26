@component('mail::message')
# Welcome {{ $corporate->contact_person }}

Thank you for registering at {{ $corporate->company_name }}.

Your login details are:

- Email: {{ $corporate->email }}
- Password: {{ $generatedPassword }}

@component('mail::button', ['url' => url('/login')])
Login Now
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
