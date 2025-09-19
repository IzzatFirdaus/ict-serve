@php
  /**
  * Ticket Confirmation Email – MYDS & MyGovEA compliant
  * For ICTServe (iServe)
  * Follows MYDS grid, typography, color tokens, and status components.
  * Uses inline styles for email client compatibility.
  */
@endphp

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>ICTServe Ticket Confirmation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- MYDS Typography (system fallback) -->
    <style type="text/css">
      @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Poppins:wght@600&display=swap');
    </style>
  </head>
  <body
    style="
      margin: 0;
      padding: 0;
      font-family: 'Inter', Arial, sans-serif;
      background: #fafafa;
      color: #18181b;
    "
  >
    <!-- Masthead -->
    <table
      width="100%"
      cellpadding="0"
      cellspacing="0"
      style="background: #2563eb; border-bottom: 4px solid #3a75f6"
    >
      <tr>
        <td style="padding: 24px">
          <table
            width="600"
            align="center"
            cellpadding="0"
            cellspacing="0"
            style="width: 100%; max-width: 600px"
          >
            <tr>
              <td valign="middle" style="width: 56px">
                <!-- Ministry/Dept Logo (replace src as needed) -->
                <img
                  src="{{ asset('images/malaysia_tourism_ministry_motac.jpeg') }}"
                  alt="MOTAC Logo"
                  width="48"
                  height="48"
                  style="display: block; border-radius: 6px"
                />
              </td>
              <td style="padding-left: 16px">
                <div
                  style="
                    font-family: Poppins, Arial, sans-serif;
                    font-size: 18px;
                    font-weight: 600;
                    color: #fff;
                    line-height: 1.1;
                  "
                >
                  Kementerian Pelancongan, Seni dan Budaya Malaysia
                </div>
                <div
                  style="
                    font-family: Inter, Arial, sans-serif;
                    font-size: 14px;
                    font-weight: 400;
                    color: #c2d5ff;
                  "
                >
                  Bahagian Pengurusan Maklumat (BPM) – ICTServe (iServe)
                </div>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>

    <!-- Main content container -->
    <table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td style="padding: 32px 0">
          <table
            width="600"
            align="center"
            cellpadding="0"
            cellspacing="0"
            style="
              background: #fff;
              border-radius: 8px;
              box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
              padding: 0 24px 24px 24px;
            "
          >
            <!-- Panel (MYDS) -->
            <tr>
              <td colspan="2" style="padding: 32px 0 12px 0">
                <div
                  style="
                    border-radius: 12px;
                    padding: 20px 24px;
                    background: #eff6ff;
                    border-left: 8px solid #2563eb;
                  "
                >
                  <span
                    style="
                      font-family: Poppins, Arial, sans-serif;
                      font-size: 22px;
                      font-weight: 600;
                      color: #2563eb;
                      display: block;
                      margin-bottom: 6px;
                    "
                  >
                    Support Ticket Confirmation
                  </span>
                  <span style="font-size: 15px; color: #3f3f46">
                    Thank you for reporting your ICT issue. We have received
                    your support ticket and it is being processed.
                  </span>
                </div>
              </td>
            </tr>

            <!-- Status & Ticket Info -->
            <tr>
              <td colspan="2" style="padding-top: 18px">
                <table
                  width="100%"
                  cellpadding="0"
                  cellspacing="0"
                  role="presentation"
                  style="font-size: 14px"
                >
                  <tr>
                    <td style="padding: 0 0 8px 0">
                      <strong style="color: #2563eb">Ticket Number:</strong>
                      <span style="font-family: monospace; color: #18181b">
                        {{ $ticket->ticket_number }}
                      </span>
                    </td>
                    <td align="right" style="color: #71717a">
                      <strong>Submitted:</strong>
                      {{ $ticket->created_at->format('d M Y, g:i A') }}
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <strong>Status:</strong>
                      <!-- MYDS Status Tag -->
                      <span
                        style="
                          background: #dbeafe;
                          color: #2563eb;
                          border-radius: 6px;
                          padding: 2px 10px 2px 8px;
                          font-size: 13px;
                          font-weight: 600;
                          vertical-align: middle;
                        "
                      >
                        {{ $ticket->status->name }}
                      </span>
                    </td>
                    <td align="right">
                      <strong>Priority:</strong>
                      <!-- MYDS Tag: color by priority -->
                      @php
                        // Ensure we use a string key when TicketPriority is an enum
                        $priorityKey =
                          is_object($ticket->priority) && method_exists($ticket->priority, 'value')
                            ? (string) $ticket->priority->value
                            : (string) $ticket->priority;
                        $priorityColorMap = [
                          'urgent' => ['#DC2626', '#FEF2F2'],
                          'high' => ['#CA8A04', '#FEF9C3'],
                          'medium' => ['#2563EB', '#EFF6FF'],
                          'low' => ['#71717A', '#F4F4F5'],
                        ];
                        $priorityColor = $priorityColorMap[$priorityKey] ?? ['#2563EB', '#EFF6FF'];
                      @endphp

                      <span
                        style="
                          background: {{ $priorityColor[1] }};
                          color: {{ $priorityColor[0] }};
                          border-radius: 6px;
                          padding: 2px 10px 2px 8px;
                          font-size: 13px;
                          font-weight: 600;
                        "
                      >
                        {{ ucfirst($priorityKey) }}
                      </span>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

            <!-- Summary List (MYDS) -->
            <tr>
              <td colspan="2" style="padding-top: 28px">
                <table
                  width="100%"
                  cellpadding="0"
                  cellspacing="0"
                  style="border-spacing: 0; font-size: 14px"
                >
                  <tr>
                    <td
                      colspan="2"
                      style="
                        font-size: 16px;
                        font-family: Poppins, Arial, sans-serif;
                        font-weight: 600;
                        color: #2563eb;
                        padding-bottom: 8px;
                      "
                    >
                      Reporter Information
                    </td>
                  </tr>
                  <tr>
                    <td style="color: #71717a; width: 150px; padding: 4px 0">
                      Name
                    </td>
                    <td>{{ $ticket->user->name }}</td>
                  </tr>
                  <tr>
                    <td style="color: #71717a; padding: 4px 0">Email</td>
                    <td>{{ $ticket->user->email }}</td>
                  </tr>
                  <tr>
                    <td style="color: #71717a; padding: 4px 0">Department</td>
                    <td>{{ $ticket->user->department }}</td>
                  </tr>
                  <tr>
                    <td style="color: #71717a; padding: 4px 0">Division</td>
                    <td>{{ $ticket->user->division }}</td>
                  </tr>
                  <tr>
                    <td style="color: #71717a; padding: 4px 0">Position</td>
                    <td>{{ $ticket->user->position }}</td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td colspan="2" style="padding-top: 24px">
                <table
                  width="100%"
                  cellpadding="0"
                  cellspacing="0"
                  style="border-spacing: 0; font-size: 14px"
                >
                  <tr>
                    <td
                      colspan="2"
                      style="
                        font-size: 16px;
                        font-family: Poppins, Arial, sans-serif;
                        font-weight: 600;
                        color: #2563eb;
                        padding-bottom: 8px;
                      "
                    >
                      Issue Details
                    </td>
                  </tr>
                  <tr>
                    <td style="color: #71717a; width: 150px; padding: 4px 0">
                      Category
                    </td>
                    <td>{{ $ticket->category->name }}</td>
                  </tr>
                  <tr>
                    <td style="color: #71717a; padding: 4px 0">Title</td>
                    <td>{{ $ticket->title }}</td>
                  </tr>
                  <tr>
                    <td style="color: #71717a; padding: 4px 0">Location</td>
                    <td>{{ $ticket->location }}</td>
                  </tr>
                  @if ($ticket->equipmentItem)
                    <tr>
                      <td style="color: #71717a; padding: 4px 0">Equipment</td>
                      <td>
                        {{ $ticket->equipmentItem->brand }}
                        {{ $ticket->equipmentItem->model }}
                      </td>
                    </tr>
                  @endif
                </table>
              </td>
            </tr>
            <tr>
              <td colspan="2" style="padding-top: 24px">
                <div style="font-size: 14px; color: #18181b">
                  <span style="font-weight: 600; color: #2563eb">
                    Description:
                  </span>
                  <br />
                  <span>{{ $ticket->description }}</span>
                </div>
              </td>
            </tr>

            <!-- Response Time Panel -->
            <tr>
              <td colspan="2" style="padding-top: 24px">
                <div
                  style="
                    background: #f4f4f5;
                    border-radius: 8px;
                    padding: 16px 20px;
                  "
                >
                  <span style="font-weight: 600; color: #2563eb">
                    Expected Response Time:
                  </span>
                  <ul
                    style="
                      padding-left: 24px;
                      margin: 8px 0 0 0;
                      color: #3f3f46;
                    "
                  >
                    @if ($ticket->priority === 'urgent')
                      <li>
                        Urgent: Response within 2-4 hours (business hours)
                      </li>
                    @elseif ($ticket->priority === 'high')
                      <li>High: Response within 8-12 hours (business hours)</li>
                    @elseif ($ticket->priority === 'medium')
                      <li>Medium: Response within 1-2 business days</li>
                    @else
                      <li>Low: Response within 3-5 business days</li>
                    @endif
                  </ul>
                  @if ($ticket->due_at)
                    <div style="margin-top: 8px; color: #18181b">
                      <strong>Expected Resolution:</strong>
                      {{ $ticket->due_at->format('d M Y, g:i A') }}
                    </div>
                  @endif
                </div>
              </td>
            </tr>

            <<<<<<< HEAD ## Expected Response Time Based on your ticket priority
            ({{ ucfirst($priority) }}), our expected response times are:

            @if ($priority === 'urgent')
              - **Urgent:** Response within 2-4 hours during business hours
            @elseif ($priority === 'high')
              - **High:** Response within 8-12 hours during business hours
            @elseif ($priority === 'medium')
              - **Medium:** Response within 1-2 business days
            @else
                - **Low:** Response within 3-5 business days
            @endif
            =======
            <!-- Next Steps Callout -->
            <tr>
              <td colspan="2" style="padding-top: 24px">
                <div
                  style="
                    border-left: 4px solid #2563eb;
                    padding: 12px 0 12px 16px;
                    background: #eff6ff;
                    border-radius: 6px;
                    font-size: 14px;
                  "
                >
                  <strong style="color: #2563eb">What happens next?</strong>
                  <ol style="margin: 8px 0 0 18px; padding: 0; color: #18181b">
                    <li>ICT support will review and prioritize your ticket.</li>
                    <li>A technician will be assigned to your case.</li>
                    <li>You will receive updates as your ticket progresses.</li>
                    <li>
                      The assigned technician may contact you for more info.
                    </li>
                  </ol>
                </div>
              </td>
            </tr>

            <!-- MYDS Button (Track Status) -->
            <tr>
              <td colspan="2" align="center" style="padding-top: 26px">
                <a
                  href="{{ route('public.track') . '?tracking_number=' . $ticket->ticket_number }}"
                  style="
                    background: #2563eb;
                    color: #fff;
                    font-family: Poppins, Arial, sans-serif;
                    font-size: 16px;
                    font-weight: 600;
                    display: inline-block;
                    padding: 12px 30px;
                    border-radius: 6px;
                    text-decoration: none;
                    box-shadow: 0 2px 6px rgba(37, 99, 235, 0.16);
                  "
                >
                  Track Ticket Status
                </a>
              </td>
            </tr>
            >>>>>>> feature/larastan-autofix

            <!-- Emergency Info (MYDS Callout style) -->
            <tr>
              <td colspan="2" style="padding-top: 32px">
                <div
                  style="
                    background: #fef2f2;
                    border-left: 5px solid #dc2626;
                    padding: 16px 24px;
                    border-radius: 6px;
                  "
                >
                  <span style="font-weight: 600; color: #dc2626">
                    Emergency Support:
                  </span>
                  <span style="color: #b91c1c">
                    If this is a critical issue affecting operations, call our
                    24/7 hotline:
                    <b>+60 3-yyyy yyyy</b>
                  </span>
                </div>
              </td>
            </tr>

            <!-- Important Notes -->
            <tr>
              <td colspan="2" style="padding-top: 24px">
                <ul
                  style="
                    font-size: 13px;
                    color: #71717a;
                    line-height: 1.6;
                    padding-left: 18px;
                  "
                >
                  <li>Please save your ticket number for future reference.</li>
                  <li>You can track your ticket status at any time.</li>
                  <li>
                    Reply to this email to provide additional info if needed.
                  </li>
                  <li>Do not create duplicate tickets for the same issue.</li>
                </ul>
              </td>
            </tr>

            <!-- Support Contacts / Footer -->
            <tr>
              <td
                colspan="2"
                style="
                  padding-top: 24px;
                  text-align: center;
                  font-size: 13px;
                  color: #52525b;
                "
              >
                <div>
                  <span style="color: #2563eb; font-weight: 600">
                    ICT Support Team
                  </span>
                  <br />
                  Email:
                  <a
                    href="mailto:ict-support@example.gov.my"
                    style="color: #2563eb; text-decoration: underline"
                  >
                    ict-support@example.gov.my
                  </a>
                  <br />
                  Phone: +60 3-xxxx xxxx
                  <br />
                  Emergency Hotline: +60 3-yyyy yyyy (24/7)
                  <br />
                  Office hours: Mon-Fri, 8:00 AM–5:00 PM
                </div>
              </td>
            </tr>
            <tr>
              <td
                colspan="2"
                style="
                  padding-top: 30px;
                  padding-bottom: 8px;
                  text-align: center;
                  font-size: 12px;
                  color: #a1a1aa;
                "
              >
                &copy; {{ date('Y') }} Bahagian Pengurusan Maklumat (BPM),
                Kementerian Pelancongan, Seni dan Budaya Malaysia. Powered by
                ICTServe (iServe).
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>
