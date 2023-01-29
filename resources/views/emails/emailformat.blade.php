<x-mail::message>
# Welcome to Vetamina!

Dear {{ $email }},

We look forward to have a deeper connection with you, 
Kindly enter the OTP code below to verify your account.

51082

<x-mail::button :url="'https://www.facebook.com/jnar.jnar.jnar'">
Developer
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
