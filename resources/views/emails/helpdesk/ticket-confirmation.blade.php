@component('mail::message')
# Support Ticket Confirmation

Dear {{ $reporterName }},

Thank you for reporting your ICT issue. We have received your support ticket and it has been logged in our system for processing.

## Ticket Details
**Ticket Number:** {{ $ticket->ticket_number }}
**Submitted on:** {{ $ticket->created_at->format('F j, Y \a\t g:i A') }}
**Status:** {{ $ticket->status->name }}
@php
	$priority = $priorityString;
@endphp
**Priority:** {{ ucfirst($priority) }}

### Reporter Information
- **Name:** {{ $ticket->user->name }}
- **Email:** {{ $ticket->user->email }}
- **Department:** {{ $ticket->user->department }}
- **Division:** {{ $ticket->user->division }}
- **Position:** {{ $ticket->user->position }}

### Issue Information
- **Category:** {{ $ticket->category->name }}
- **Title:** {{ $ticket->title }}
- **Location:** {{ $ticket->location }}
@if($ticket->equipmentItem)
- **Related Equipment:** {{ $ticket->equipmentItem->brand }} {{ $ticket->equipmentItem->model }}
@endif

### Issue Description
{{ $ticket->description }}

## Expected Response Time
Based on your ticket priority ({{ ucfirst($priority) }}), our expected response times are:

@if($priority === 'urgent')
- **Urgent:** Response within 2-4 hours during business hours
@elseif($priority === 'high')
- **High:** Response within 8-12 hours during business hours
@elseif($priority === 'medium')
- **Medium:** Response within 1-2 business days
@else
- **Low:** Response within 3-5 business days
@endif

@if($ticket->due_at)
**Expected Resolution:** {{ $ticket->due_at->format('F j, Y \a\t g:i A') }}
@endif

## What Happens Next?

1. Our ICT support team will review and prioritize your ticket
2. A technician will be assigned to your case
3. You will receive updates as your ticket progresses
4. The assigned technician may contact you for additional information

@component('mail::button', ['url' => route('public.track').'?tracking_number='.$ticket->ticket_number])
Track Ticket Status
@endcomponent

## Emergency Support
If this is a critical issue affecting operations, please call our emergency hotline:
**Emergency Hotline:** +60 3-yyyy yyyy (Available 24/7)

## Important Notes
- Please save your ticket number: **{{ $ticket->ticket_number }}** for future reference
- You can track your ticket status using the link above
- Reply to this email if you need to provide additional information
- Do not create duplicate tickets for the same issue

If you have any questions or concerns, please contact our ICT support team:

**Email:** ict-support@example.gov.my
**Phone:** +60 3-xxxx xxxx
**Emergency Hotline:** +60 3-yyyy yyyy (24/7)
**Office Hours:** Monday - Friday, 8:00 AM - 5:00 PM

Thank you for using ICT Serve.

Best regards,
ICT Support Team
@endcomponent
