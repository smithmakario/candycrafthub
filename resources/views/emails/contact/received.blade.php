<x-mail::message>
# New contact form message

**From:** {{ $senderName }} ({{ $senderEmail }})

**Subject:** {{ $subjectLabel }}

---

{{ $messageBody }}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
