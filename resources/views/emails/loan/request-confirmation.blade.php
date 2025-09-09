@component('mail::message')
# Loan Request Confirmation

Dear {{ $borrowerName }},

Thank you for submitting your equipment loan request. We have received your request and it is now being processed by our ICT team.

## Request Details
**Request Number:** {{ $loanRequest->request_number }}
**Submitted on:** {{ $loanRequest->created_at->format('F j, Y \a\t g:i A') }}
**Status:** {{ $loanRequest->status->name }}

### Borrower Information
- **Name:** {{ $loanRequest->user->name }}
- **Email:** {{ $loanRequest->user->email }}
- **Department:** {{ $loanRequest->user->department }}
- **Division:** {{ $loanRequest->user->division }}
- **Position:** {{ $loanRequest->user->position }}

### Loan Details
- **Start Date:** {{ $loanRequest->loan_start_date->format('F j, Y') }}
- **End Date:** {{ $loanRequest->loan_end_date->format('F j, Y') }}
- **Duration:** {{ $loanRequest->loan_start_date->diffInDays($loanRequest->loan_end_date) }} days
- **Purpose:** {{ $loanRequest->purpose }}
- **Location:** {{ $loanRequest->location }}

### Requested Equipment
@foreach($loanRequest->loanItems as $loanItem)
- {{ $loanItem->equipmentItem->category->name }}: {{ $loanItem->equipmentItem->brand }} {{ $loanItem->equipmentItem->model }}
@endforeach

## What Happens Next?

1. Our ICT team will review your request and check equipment availability
2. You will receive an approval notification within 1-2 business days
3. Once approved, you can collect the equipment from our ICT office
4. Please check your email regularly for updates

@component('mail::button', ['url' => route('public.track').'?tracking_number='.$loanRequest->request_number])
Track Request Status
@endcomponent

## Important Notes
- Please save your request number: **{{ $loanRequest->request_number }}** for future reference
- You can track your request status using the link above
- Contact our ICT team if you have any questions or need to modify your request

If you have any questions or concerns, please contact our ICT support team:

**Email:** ict-support@example.gov.my
**Phone:** +60 3-xxxx xxxx
**Office Hours:** Monday - Friday, 8:00 AM - 5:00 PM

Thank you for using ICT Serve.

Best regards,
ICT Department
@endcomponent
