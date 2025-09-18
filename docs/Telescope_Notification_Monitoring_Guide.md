# Laravel Telescope Notification Monitoring Guide

## Overview

This guide explains how to use Laravel Telescope to monitor, debug, and maintain the notification system in ICTServe (iServe). Telescope provides comprehensive monitoring for all email notifications, system events, and background jobs.

## Accessing Telescope Dashboard

### Local Development

- URL: `http://127.0.0.1:8000/telescope`
- Access: Automatically available in local environment
- Direct links:
  - Mail: [http://127.0.0.1:8000/telescope/mail](http://127.0.0.1:8000/telescope/mail)
  - Notifications: [http://127.0.0.1:8000/telescope/notifications](http://127.0.0.1:8000/telescope/notifications)

### Production Environment

- URL: `https://your-domain.com/telescope`
- Access: Restricted to:
  - Admin users (`admin@motac.gov.my`, `ict@motac.gov.my`)
  - Users with 'Admin' or 'ICT Admin' roles
  - MOTAC domain users with Admin privileges

## Monitoring Notification Types

### 1. Helpdesk Tickets

**Tag**: `notification:helpdesk`

- **Notification Class**: `TicketCreatedNotification`, `TicketStatusUpdatedNotification`
- **Triggers**: New ticket creation, status updates, assignments
- **Key Data**: Ticket ID, category, priority, assignee

### 2. Equipment Loan Requests

**Tag**: `notification:loan`

- **Notification Class**: `LoanRequestSubmittedNotification`
- **Triggers**: New loan applications, approvals, returns
- **Key Data**: Request ID, equipment type, requester, duration

### 3. Damage Complaints

**Tag**: `notification:damage`

- **Notification Class**: `DamageComplaintSubmittedNotification`
- **Triggers**: Equipment damage reports, repair updates
- **Key Data**: Complaint ID, asset details, damage description

## Dashboard Navigation

### Mail Watcher

1. Click "Mail" in the left sidebar
2. View all outgoing emails with:
   - Recipient addresses
   - Subject lines
   - Send timestamps
   - Delivery status
   - Email content preview

### Notification Watcher

1. Click "Notifications" in the left sidebar
2. Filter by tags:
   - `notification:helpdesk` - Helpdesk-related notifications
   - `notification:loan` - Equipment loan notifications
   - `notification:damage` - Damage complaint notifications
3. View notification details:
   - Notification class
   - Recipient information
   - Payload data
   - Queue status

### Filtering and Search

- **By Type**: Select specific watchers (Mail, Notifications, Jobs)
- **By Time**: Use date range filters
- **By Tag**: Search for specific tags like `notification:helpdesk`
- **By Status**: Filter successful vs failed notifications

## SMTP Integration

### Papercut SMTP Setup

- **Host**: `127.0.0.1` (localhost)
- **Port**: `25`
- **Purpose**: Local email testing and development
- **Monitoring**: All emails sent through SMTP are captured by Telescope

### Configuration Details

```php
// Mail settings (from config/mail.php)
'default' => 'smtp',
'mailers' => [
    'smtp' => [
        'host' => '127.0.0.1',
        'port' => 25,
    ]
],
'from' => [
    'address' => 'noreply@motac.gov.my',
    'name' => 'ICT Serve (iServe)',
]
```

## Debugging Common Issues

### 1. Missing Notifications

**Symptoms**: Expected notifications not appearing in Telescope
**Solutions**:

- Check notification class exists and is queued properly
- Verify user has valid email address
- Check if notification implements proper interfaces

### 2. Failed Email Delivery

**Symptoms**: Notifications appear in Telescope but emails not delivered
**Solutions**:

- Verify SMTP configuration
- Check Papercut SMTP is running (development)
- Review mail server logs

### 3. Queue Processing Issues

**Symptoms**: Notifications stuck in pending state
**Solutions**:

- Check queue worker is running: `php artisan queue:work`
- Review failed jobs: `php artisan queue:failed`
- Monitor Jobs watcher in Telescope

## Maintenance Tasks

### Daily Monitoring

1. Check Telescope dashboard for failed notifications
2. Review mail delivery success rates
3. Monitor queue processing performance

### Weekly Tasks

1. Clear old Telescope entries: `php artisan telescope:prune`
2. Review notification performance metrics
3. Check for any recurring failure patterns

### Monthly Tasks

1. Update notification templates if needed
2. Review user feedback on email communications
3. Optimize notification timing and frequency

## Performance Considerations

### Telescope Storage

- Telescope stores all monitored data in database
- Use `telescope:prune` command regularly to manage storage
- Configure appropriate retention periods

### Monitoring Impact

- Telescope adds minimal overhead in production
- Mail and notification monitoring is optimized
- Background job processing remains efficient

## Security Notes

### Access Control

- Telescope access is restricted in production
- Sensitive data is automatically hidden
- User authentication required for dashboard access

### Data Privacy

- Email content is logged for debugging
- Personal information may be visible in notifications
- Follow MOTAC data protection guidelines

## Support and Troubleshooting

### Log Files

- Laravel logs: `storage/logs/laravel.log`
- Telescope database tables: `telescope_*`
- Mail logs: Check SMTP server logs

### Common Commands

```bash
# Start queue processing
php artisan queue:work

# Clear Telescope data
php artisan telescope:prune

# Restart queue workers
php artisan queue:restart

# Check queue status
php artisan queue:monitor
```

### Getting Help

- Contact ICT Admin team for Telescope access issues
- Review Laravel documentation for notification debugging
- Check system logs for detailed error information

## Migration and Setup Notes

### Migration Resolution

If you encounter migration conflicts with Telescope (duplicate `telescope_entries` table), follow these steps:

1. **Delete Duplicate Migration Files**: Remove any duplicate migration files:

   ```bash
   Remove-Item "database\migrations\2025_09_12_143323_create_telescope_entries_table.php" -Force
   ```

2. **Clean Migration Table**: If needed, manually remove duplicate entries from the `migrations` table:

   ```sql
   DELETE FROM migrations WHERE migration = '2025_09_12_143323_create_telescope_entries_table';
   ```

3. **Re-run Migrations**:

   ```bash
   php artisan migrate --no-interaction
   ```

### Verification Steps

After setup, verify Telescope is working:

1. **Check Database**: Confirm mail/notification events are being recorded:

   ```sql
   SELECT type, COUNT(*) as count FROM telescope_entries
   WHERE type IN ('mail', 'notification') GROUP BY type;
   ```

2. **Trigger Test Notification**: Create a test helpdesk ticket to generate notification events.

3. **Process Queue**: Run queue worker to process notifications:

   ```bash
   php artisan queue:work --stop-when-empty --no-interaction
   ```

4. **Verify Dashboard**: Navigate to Telescope dashboard sections for Mail and Notifications.

### Troubleshooting Dashboard Display

If the Telescope dashboard shows "Scanning..." continuously:

- The events are recorded in the database but frontend may have loading issues
- Refresh the page or try different browser
- Check browser console for JavaScript errors
- Verify Laravel development server is running properly

---

**Document Version**: 1.1  
**Last Updated**: September 2025  
**Maintained by**: ICT Admin Team
