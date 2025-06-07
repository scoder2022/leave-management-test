@component('mail::message')
# Leave Request Update

Your leave request ({{ $leaveRequest->leave_type }}) from **<span style="color:seagreen;font-weight:bold">{{ $leaveRequest->start_date }}</span>
** to ** <span style="color:seagreen;font-weight:bold">{{ $leaveRequest->end_date }}</span> ** has been:

{!!
    '<p style="color:' .
    ($leaveRequest->status === 'approved' ? 'green' : ($leaveRequest->status === 'rejected' ? 'red' : 'orange')) .
    '; font-weight:bold; font-size:16px;">' .
    strtoupper($leaveRequest->status) .
    '</p>'
!!}

---

### Leave Details:
- **Type:** {{ $leaveRequest->leave_type }}
- **From:** {{ \Carbon\Carbon::parse($leaveRequest->start_date)->toFormattedDateString() }}
- **To:** {{ \Carbon\Carbon::parse($leaveRequest->end_date)->toFormattedDateString() }}
- **Reason:** {{ $leaveRequest->reason }}

@if($leaveRequest->admin_comment)
### Admin Comment:
> {{ $leaveRequest->admin_comment }}
@endif

Thanks,
{{ config('app.name') }}
@endcomponent
