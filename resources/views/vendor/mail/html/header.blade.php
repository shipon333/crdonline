<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
@else
    <img src="{{ asset('backend') }}/images/{{ setting('logo') }}" class="logo" alt="{{ setting('company_name') }} Logo">
@endif
</a>
</td>
</tr>
