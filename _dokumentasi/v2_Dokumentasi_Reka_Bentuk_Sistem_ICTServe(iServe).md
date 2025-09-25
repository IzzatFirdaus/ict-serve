# ICTServe (iServe) Complete Documentation Suite

## Document Index

1. [System Design Documentation](#1-system-design-documentation)
2. [System Documentation](#2-system-documentation)
3. [ICT Asset Loan Application Flow](#3-ict-asset-loan-application-flow)
4. [Helpdesk & ServiceDesk Flow](#4-helpdesk--servicedesk-flow)
5. [Email Notification System](#5-email-notification-system)
6. [User & Organization Data Schema](#6-user--organization-data-schema)

---

# 1. System Design Documentation

**Document Version:** 2.0  
**Last Updated:** September 25, 2025  
**Status:** Production Ready  
**Classification:** Internal Technical Documentation

## Executive Summary

ICTServe (iServe) v1.0 is a comprehensive ICT service management platform for the Ministry of Tourism, Arts and Culture (MOTAC) Malaysia. Built on Laravel 12 with Livewire 3 and Filament 4, the system provides integrated management for ICT equipment loans and helpdesk operations while ensuring full compliance with Malaysian Government Design System (MYDS) and MyGOVEA principles.

## Table of Contents

- [1.1 System Overview](#11-system-overview)
- [1.2 Core Objectives](#12-core-objectives)
- [1.3 Technical Architecture](#13-technical-architecture)
- [1.4 Database Design](#14-database-design)
- [1.5 Business Workflows](#15-business-workflows)
- [1.6 User Interface Design](#16-user-interface-design)
- [1.7 Security & Compliance](#17-security--compliance)
- [1.8 Deployment Strategy](#18-deployment-strategy)

## 1.1 System Overview

ICTServe consolidates two critical operational domains:

### Core Modules

| Module | Description | Key Features |
|--------|-------------|--------------|
| **Equipment Loan Management** | Manages ICT equipment borrowing lifecycle | Request submission, approval workflow, issuance tracking, return processing |
| **Helpdesk & Support** | Comprehensive IT support ticketing system | Ticket creation, assignment, resolution tracking, SLA monitoring |

### Technology Stack

```yaml
Framework: Laravel 12
Frontend: Livewire 3, Alpine.js
Admin Panel: Filament 4
Database: MySQL 8.0+
Cache: Redis
Queue: Database/Redis
Mail: SMTP/Mailtrap
Container: Docker
CI/CD: GitHub Actions
```

## 1.2 Core Objectives

### Primary Goals

1. **Unified Data Management** - Single source of truth for all ICT operations
2. **Automated Workflows** - Standardized, efficient processes with minimal manual intervention
3. **Role-Based Access Control** - Granular permissions based on organizational hierarchy
4. **Real-time Reporting** - Live dashboards and analytics for informed decision-making
5. **MYDS Compliance** - Full adherence to government design standards
6. **Scalable Architecture** - Modular design supporting future expansion

### Key Performance Indicators

| Metric | Target | Measurement |
|--------|--------|-------------|
| System Uptime | 99.9% | Monthly average |
| Request Processing Time | < 2 seconds | 95th percentile |
| User Satisfaction | > 85% | Quarterly survey |
| Ticket Resolution Rate | > 90% | Within SLA |

## 1.3 Technical Architecture

### 1.3.1 MVC Pattern Implementation

```
app/
├── Http/
│   ├── Controllers/          # Request handling
│   ├── Middleware/           # Request filtering
│   └── Requests/            # Validation rules
├── Models/                  # Data entities
├── Services/                # Business logic
├── Policies/                # Authorization
├── Observers/               # Model events
└── Livewire/               # Dynamic components
```

### 1.3.2 Service Layer Architecture

```php
// Example Service Pattern
class LoanApplicationService
{
    public function createApplication(array $data): LoanApplication
    {
        DB::beginTransaction();
        try {
            $application = LoanApplication::create($data);
            $this->createApplicationItems($application, $data['items']);
            $this->notifyStakeholders($application);
            DB::commit();
            return $application;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new ApplicationCreationException($e->getMessage());
        }
    }
}
```

### 1.3.3 Component Architecture

| Layer | Technology | Purpose |
|-------|------------|---------|
| Presentation | Blade, Livewire | User interface rendering |
| Application | Controllers, Services | Business logic processing |
| Domain | Models, Policies | Core business rules |
| Infrastructure | Repositories, APIs | External system integration |

## 1.4 Database Design

### 1.4.1 Core Schema Overview

```mermaid
erDiagram
    USERS ||--o{ LOAN_APPLICATIONS : creates
    USERS ||--o{ HELPDESK_TICKETS : submits
    DEPARTMENTS ||--o{ USERS : employs
    GRADES ||--o{ USERS : assigns
    LOAN_APPLICATIONS ||--o{ LOAN_APPLICATION_ITEMS : contains
    LOAN_APPLICATIONS ||--o{ LOAN_TRANSACTIONS : generates
    EQUIPMENT ||--o{ LOAN_TRANSACTION_ITEMS : involves
    HELPDESK_TICKETS ||--o{ HELPDESK_COMMENTS : has
```

### 1.4.2 Key Tables

#### Users Table
```sql
CREATE TABLE users (
    id BIGINT PRIMARY KEY,
    title VARCHAR(50),
    name VARCHAR(255) NOT NULL,
    identification_number VARCHAR(20) UNIQUE,
    email VARCHAR(255) UNIQUE NOT NULL,
    department_id BIGINT FOREIGN KEY,
    grade_id BIGINT FOREIGN KEY,
    position_id BIGINT FOREIGN KEY,
    status ENUM('active', 'inactive', 'suspended'),
    created_by BIGINT,
    updated_by BIGINT,
    deleted_by BIGINT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    deleted_at TIMESTAMP
);
```

### 1.4.3 Audit Trail Implementation

All critical tables include audit fields automatically populated via Laravel Auditing:

- `created_by` - User who created the record
- `updated_by` - Last user to modify
- `deleted_by` - User who soft-deleted
- Timestamps for all operations

## 1.5 Business Workflows

### 1.5.1 Equipment Loan Workflow

```mermaid
stateDiagram-v2
    [*] --> Draft: User creates application
    Draft --> Pending_Support: Submit for approval
    Pending_Support --> Approved: Officer approves
    Pending_Support --> Rejected: Officer rejects
    Approved --> Issued: BPM staff issues equipment
    Issued --> Returned: User returns equipment
    Returned --> Completed: Process complete
    Rejected --> [*]
    Completed --> [*]
```

### 1.5.2 Approval Matrix

| Requester Grade | Minimum Approver Grade | Authority Level |
|-----------------|------------------------|-----------------|
| 54 and below | 41 | Departmental |
| 52-48 | 44 | Divisional |
| 44-41 | 48 | Senior Management |
| JUSA and above | JUSA B | Executive |

## 1.6 User Interface Design

### 1.6.1 MYDS Compliance

All UI components strictly adhere to MYDS guidelines:

```css
/* MYDS Color Palette */
:root {
    --myds-primary: #2563EB;
    --myds-success: #10B981;
    --myds-warning: #F59E0B;
    --myds-danger: #EF4444;
    --myds-neutral: #6B7280;
}

/* Typography */
.myds-heading {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
}

.myds-body {
    font-family: 'Inter', sans-serif;
    font-weight: 400;
}
```

### 1.6.2 Responsive Design

| Breakpoint | Width | Columns | Use Case |
|------------|-------|---------|----------|
| Mobile | < 640px | 4 | Smartphones |
| Tablet | 640-1024px | 8 | Tablets, small laptops |
| Desktop | > 1024px | 12 | Desktop computers |

### 1.6.3 Component Library

```php
// MYDS Button Component
<x-myds.button 
    type="primary"
    size="medium"
    icon="check"
    :loading="$isProcessing">
    {{ __('Submit Application') }}
</x-myds.button>
```

## 1.7 Security & Compliance

### 1.7.1 Security Measures

| Layer | Implementation | Purpose |
|-------|---------------|---------|
| Authentication | Laravel Fortify | User identity verification |
| Authorization | Spatie Permissions | Role-based access control |
| Data Protection | Encryption at rest | Sensitive data security |
| Session Management | Redis sessions | Secure session handling |
| API Security | Sanctum tokens | API authentication |
| Input Validation | Form Requests | Data integrity |

### 1.7.2 Compliance Standards

- **PDPA Compliance** - Personal data protection
- **ISO 27001** - Information security management
- **MAMPU Standards** - Government IT guidelines
- **WCAG 2.1 AA** - Web accessibility

## 1.8 Deployment Strategy

### 1.8.1 Environment Configuration

```yaml
# Production Environment
APP_ENV: production
APP_DEBUG: false
APP_URL: https://ictserve.motac.gov.my

# Database
DB_CONNECTION: mysql
DB_HOST: ${RDS_HOSTNAME}
DB_DATABASE: ictserve_prod

# Cache & Session
CACHE_DRIVER: redis
SESSION_DRIVER: redis
QUEUE_CONNECTION: redis

# Security
FORCE_HTTPS: true
SESSION_SECURE_COOKIE: true
```

### 1.8.2 CI/CD Pipeline

```mermaid
graph LR
    A[Code Push] --> B[GitHub Actions]
    B --> C[Automated Tests]
    C --> D{Tests Pass?}
    D -->|Yes| E[Build Docker Image]
    D -->|No| F[Notify Developer]
    E --> G[Deploy to Staging]
    G --> H[UAT Approval]
    H --> I[Production Deploy]
```

### 1.8.3 Monitoring & Maintenance

| Aspect | Tool | Frequency |
|--------|------|-----------|
| Application Performance | New Relic | Real-time |
| Error Tracking | Sentry | Real-time |
| Database Backup | AWS RDS | Daily |
| Security Scanning | SonarQube | Weekly |
| Log Analysis | CloudWatch | Continuous |

---

# 2. System Documentation

**Document Version:** 2.0  
**Last Updated:** September 25, 2025  
**Status:** Production Ready  
**Classification:** Technical Reference

## Executive Summary

This document provides comprehensive technical documentation for the ICTServe system, covering installation, configuration, operation, and maintenance procedures. It serves as the primary reference for system administrators, developers, and support personnel.

## Table of Contents

- [2.1 System Requirements](#21-system-requirements)
- [2.2 Installation Guide](#22-installation-guide)
- [2.3 Configuration](#23-configuration)
- [2.4 System Components](#24-system-components)
- [2.5 API Documentation](#25-api-documentation)
- [2.6 Troubleshooting](#26-troubleshooting)
- [2.7 Maintenance Procedures](#27-maintenance-procedures)

## 2.1 System Requirements

### 2.1.1 Server Requirements

| Component | Minimum | Recommended |
|-----------|---------|-------------|
| CPU | 4 cores | 8 cores |
| RAM | 8 GB | 16 GB |
| Storage | 100 GB SSD | 500 GB NVMe |
| OS | Ubuntu 20.04 LTS | Ubuntu 22.04 LTS |
| PHP | 8.2 | 8.3 |
| MySQL | 8.0 | 8.0.30+ |
| Redis | 6.0 | 7.0 |
| Node.js | 18.x | 20.x |

### 2.1.2 Software Dependencies

```json
{
    "laravel/framework": "^12.0",
    "livewire/livewire": "^3.0",
    "filament/filament": "^4.0",
    "spatie/laravel-permission": "^6.0",
    "barryvdh/laravel-dompdf": "^2.0",
    "laravel/fortify": "^1.19",
    "laravel/jetstream": "^4.0"
}
```

## 2.2 Installation Guide

### 2.2.1 Prerequisites

```bash
# Update system packages
sudo apt update && sudo apt upgrade -y

# Install required packages
sudo apt install -y git curl zip unzip nginx mysql-server redis-server

# Install PHP and extensions
sudo apt install -y php8.3-fpm php8.3-mysql php8.3-xml php8.3-mbstring \
    php8.3-curl php8.3-gd php8.3-intl php8.3-zip php8.3-redis

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Node.js and npm
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install -y nodejs
```

### 2.2.2 Application Setup

```bash
# Clone repository
git clone https://github.com/motac/ictserve.git
cd ictserve

# Install PHP dependencies
composer install --optimize-autoloader --no-dev

# Install Node dependencies
npm install && npm run build

# Configure environment
cp .env.example .env
php artisan key:generate

# Configure database
mysql -u root -p -e "CREATE DATABASE ictserve;"
mysql -u root -p -e "CREATE USER 'ictserve'@'localhost' IDENTIFIED BY 'secure_password';"
mysql -u root -p -e "GRANT ALL ON ictserve.* TO 'ictserve'@'localhost';"

# Run migrations and seeders
php artisan migrate --force
php artisan db:seed --class=ProductionSeeder

# Set permissions
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# Optimize application
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan filament:cache-components
```

### 2.2.3 Web Server Configuration

```nginx
# /etc/nginx/sites-available/ictserve
server {
    listen 80;
    server_name ictserve.motac.gov.my;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name ictserve.motac.gov.my;
    root /var/www/ictserve/public;
    
    ssl_certificate /etc/ssl/certs/ictserve.crt;
    ssl_certificate_key /etc/ssl/private/ictserve.key;
    
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
    
    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## 2.3 Configuration

### 2.3.1 Environment Variables

```env
# Application
APP_NAME="ICTServe"
APP_ENV=production
APP_KEY=base64:generated_key_here
APP_DEBUG=false
APP_URL=https://ictserve.motac.gov.my

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ictserve
DB_USERNAME=ictserve
DB_PASSWORD=secure_password

# Cache & Session
CACHE_DRIVER=redis
SESSION_DRIVER=redis
SESSION_LIFETIME=120

# Queue
QUEUE_CONNECTION=redis

# Mail
MAIL_MAILER=smtp
MAIL_HOST=smtp.gov.my
MAIL_PORT=587
MAIL_USERNAME=ictserve@motac.gov.my
MAIL_PASSWORD=mail_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@motac.gov.my
MAIL_FROM_NAME="${APP_NAME}"

# Redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Security
FORCE_HTTPS=true
SESSION_SECURE_COOKIE=true
```

### 2.3.2 Application Configuration

```php
// config/ictserve.php
return [
    'approval' => [
        'minimum_grade_level' => 41,
        'executive_grades' => ['JUSA A', 'JUSA B', 'JUSA C'],
    ],
    
    'loan' => [
        'max_duration_days' => 30,
        'reminder_days_before' => [7, 3, 1],
        'accessories' => [
            'laptop' => ['charger', 'bag', 'mouse'],
            'projector' => ['remote', 'cable_hdmi', 'cable_vga'],
        ],
    ],
    
    'helpdesk' => [
        'priority_levels' => ['low', 'medium', 'high', 'critical'],
        'sla_hours' => [
            'critical' => 4,
            'high' => 8,
            'medium' => 24,
            'low' => 48,
        ],
    ],
];
```

## 2.4 System Components

### 2.4.1 Core Modules

| Module | Namespace | Description |
|--------|-----------|-------------|
| Authentication | `App\Http\Controllers\Auth` | User authentication and 2FA |
| Equipment Management | `App\Http\Controllers\Equipment` | Equipment inventory and tracking |
| Loan Processing | `App\Http\Controllers\Loan` | Loan application workflow |
| Helpdesk | `App\Http\Controllers\Helpdesk` | Support ticket management |
| Reporting | `App\Http\Controllers\Reports` | Analytics and reporting |
| Admin Panel | `App\Filament` | Administrative interface |

### 2.4.2 Service Classes

```php
namespace App\Services;

class LoanApplicationService
{
    public function createApplication(array $data): LoanApplication;
    public function approveApplication(int $id, User $approver): bool;
    public function rejectApplication(int $id, string $reason): bool;
    public function issueEquipment(int $applicationId, array $items): LoanTransaction;
    public function returnEquipment(int $transactionId, array $items): bool;
}

class HelpdeskService  
{
    public function createTicket(array $data): HelpdeskTicket;
    public function assignTicket(int $id, User $agent): bool;
    public function updateStatus(int $id, string $status): bool;
    public function addComment(int $id, string $comment, bool $internal): bool;
    public function resolveTicket(int $id, string $resolution): bool;
}
```

### 2.4.3 Livewire Components

| Component | Path | Purpose |
|-----------|------|---------|
| ApplicationForm | `app/Livewire/Loan/ApplicationForm.php` | Dynamic loan application form |
| TicketList | `app/Livewire/Helpdesk/TicketList.php` | Real-time ticket listing |
| ApprovalDashboard | `app/Livewire/Approval/Dashboard.php` | Approval management interface |
| EquipmentSearch | `app/Livewire/Equipment/Search.php` | Equipment availability search |

## 2.5 API Documentation

### 2.5.1 Authentication

```http
POST /api/login
Content-Type: application/json

{
    "email": "user@motac.gov.my",
    "password": "password123"
}

Response:
{
    "token": "bearer_token_here",
    "user": {
        "id": 1,
        "name": "John Doe",
        "role": "staff"
    }
}
```

### 2.5.2 Equipment Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/equipment` | List available equipment |
| GET | `/api/equipment/{id}` | Get equipment details |
| POST | `/api/equipment/check-availability` | Check availability for date range |

### 2.5.3 Loan Application Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/loans/apply` | Submit new application |
| GET | `/api/loans/my-applications` | Get user's applications |
| PUT | `/api/loans/{id}/cancel` | Cancel application |
| GET | `/api/loans/{id}/status` | Check application status |

## 2.6 Troubleshooting

### 2.6.1 Common Issues

| Issue | Symptoms | Solution |
|-------|----------|----------|
| 500 Error | White screen, error page | Check Laravel logs in `storage/logs` |
| Database Connection | "Connection refused" error | Verify MySQL service and credentials |
| Permission Denied | Cannot write to storage | Run `chmod -R 775 storage` |
| Queue Not Processing | Jobs stuck in queue | Ensure queue worker is running |
| Mail Not Sending | No email notifications | Check SMTP configuration |

### 2.6.2 Debug Commands

```bash
# Clear all caches
php artisan optimize:clear

# Check application health
php artisan health:check

# View failed jobs
php artisan queue:failed

# Test database connection
php artisan db:show

# Check route list
php artisan route:list

# Verify configuration
php artisan config:show app
```

### 2.6.3 Log Locations

| Log Type | Location | Purpose |
|----------|----------|---------|
| Application | `storage/logs/laravel.log` | General application logs |
| Queue | `storage/logs/queue.log` | Queue processing logs |
| Mail | `storage/logs/mail.log` | Email sending logs |
| Audit | `storage/logs/audit.log` | User action audit trail |

## 2.7 Maintenance Procedures

### 2.7.1 Daily Maintenance

```bash
#!/bin/bash
# Daily maintenance script

# Backup database
mysqldump -u ictserve -p ictserve > /backup/ictserve_$(date +%Y%m%d).sql

# Clear old logs
find /var/www/ictserve/storage/logs -name "*.log" -mtime +30 -delete

# Check disk space
df -h | grep -E '^/dev/'

# Check service status
systemctl status nginx mysql redis php8.3-fpm
```

### 2.7.2 Weekly Maintenance

- Review error logs for patterns
- Update security patches
- Check backup integrity
- Review performance metrics
- Clean temporary files

### 2.7.3 Monthly Maintenance

- Full system backup
- Database optimization
- Security audit
- Performance tuning
- Update dependencies

---

# 3. ICT Asset Loan Application Flow

**Document Version:** 2.0  
**Last Updated:** September 25, 2025  
**Status:** Production Ready  
**Classification:** Process Documentation

## Executive Summary

This document details the complete workflow for ICT asset loan applications within the ICTServe system, from initial request through equipment return and process completion.

## Table of Contents

- [3.1 Process Overview](#31-process-overview)
- [3.2 User Roles & Responsibilities](#32-user-roles--responsibilities)
- [3.3 Application Submission](#33-application-submission)
- [3.4 Approval Workflow](#34-approval-workflow)
- [3.5 Equipment Issuance](#35-equipment-issuance)
- [3.6 Equipment Return](#36-equipment-return)
- [3.7 Process Metrics](#37-process-metrics)

## 3.1 Process Overview

### 3.1.1 Workflow Diagram

```mermaid
flowchart TD
    Start([Start]) --> Create[Create Application]
    Create --> Validate{Valid?}
    Validate -->|No| Create
    Validate -->|Yes| Submit[Submit Application]
    Submit --> Review[Officer Review]
    Review --> Decision{Approve?}
    Decision -->|No| Reject[Application Rejected]
    Decision -->|Yes| Approve[Application Approved]
    Approve --> Ready[Ready for Issuance]
    Ready --> Issue[Issue Equipment]
    Issue --> InUse[Equipment In Use]
    InUse --> Return[Return Equipment]
    Return --> Check{Condition OK?}
    Check -->|Yes| Complete[Process Complete]
    Check -->|No| Report[Damage Report]
    Report --> Complete
    Reject --> End([End])
    Complete --> End
```

### 3.1.2 Process Stages

| Stage | Duration | Responsible Party |
|-------|----------|------------------|
| Application Creation | 5-10 minutes | Applicant |
| Approval Review | 1-2 business days | Supporting Officer |
| Equipment Issuance | 30 minutes | BPM Staff |
| Usage Period | As approved | Applicant |
| Return Processing | 30 minutes | BPM Staff |

## 3.2 User Roles & Responsibilities

### 3.2.1 Role Matrix

| Role | Responsibilities | System Access |
|------|-----------------|---------------|
| **Applicant** | Submit applications, collect/return equipment | Create, view own applications |
| **Supporting Officer** | Review and approve/reject applications | View, approve/reject applications |
| **BPM Staff** | Issue and receive equipment | Process issuance/returns |
| **IT Administrator** | System oversight, reporting | Full system access |

### 3.2.2 Approval Authority

```php
// Approval grade requirements
$approvalMatrix = [
    'grade_54_below' => 'minimum_grade_41',
    'grade_52_48' => 'minimum_grade_44',
    'grade_44_41' => 'minimum_grade_48',
    'jusa_above' => 'minimum_jusa_b',
];
```

## 3.3 Application Submission

### 3.3.1 Required Information

```yaml
Applicant Details:
  - Name
  - Staff ID
  - Department
  - Position/Grade
  - Contact Number
  - Email

Loan Details:
  - Purpose of Loan
  - Usage Location
  - Start Date
  - End Date
  - Equipment Required

Equipment Items:
  - Type (Laptop/Projector/etc)
  - Quantity
  - Specific Requirements
```

### 3.3.2 Submission Process

1. **Access System**
   ```
   URL: https://ictserve.motac.gov.my/loans/new
   Authentication: Required
   ```

2. **Complete Form**
   - Fill in all required fields
   - Select equipment from available inventory
   - Specify loan period (maximum 30 days)
   - Provide justification

3. **Review & Submit**
   - Verify information accuracy
   - Accept terms and conditions
   - Submit for approval

4. **Confirmation**
   - Receive application number
   - Email notification sent
   - Status: "Pending Approval"

### 3.3.3 Validation Rules

| Field | Validation | Error Message |
|-------|------------|---------------|
| Start Date | >= Today + 1 day | "Start date must be at least tomorrow" |
| End Date | <= Start + 30 days | "Maximum loan period is 30 days" |
| Quantity | <= Available stock | "Requested quantity exceeds availability" |
| Purpose | Min 20 characters | "Please provide detailed purpose" |

## 3.4 Approval Workflow

### 3.4.1 Approval Process

```mermaid
sequenceDiagram
    participant A as Applicant
    participant S as System
    participant O as Officer
    participant B as BPM Staff
    
    A->>S: Submit Application
    S->>O: Notification (Pending Approval)
    O->>S: Review Application
    
    alt Approve
        O->>S: Approve Application
        S->>A: Approval Notification
        S->>B: Ready for Issuance
    else Reject
        O->>S: Reject with Reason
        S->>A: Rejection Notification
    end
```

### 3.4.2 Approval Criteria

| Criterion | Description | Weight |
|-----------|-------------|--------|
| **Purpose Validity** | Legitimate business need | 40% |
| **Equipment Availability** | Stock availability for requested period | 30% |
| **User History** | Previous loan compliance | 20% |
| **Priority Level** | Urgency of request | 10% |

### 3.4.3 Decision Actions

```php
// Approval action
public function approve(LoanApplication $application, Request $request)
{
    $application->update([
        'status' => 'approved',
        'approved_by' => auth()->id(),
        'approved_at' => now(),
        'approval_notes' => $request->notes,
    ]);
    
    // Notify stakeholders
    $application->user->notify(new ApplicationApprovedNotification($application));
    BPMTeam::notify(new EquipmentReadyForIssuanceNotification($application));
}

// Rejection action
public function reject(LoanApplication $application, Request $request)
{
    $application->update([
        'status' => 'rejected',
        'rejected_by' => auth()->id(),
        'rejected_at' => now(),
        'rejection_reason' => $request->reason,
    ]);
    
    $application->user->notify(new ApplicationRejectedNotification($application));
}
```

## 3.5 Equipment Issuance

### 3.5.1 Pre-Issuance Checklist

- [ ] Application approved
- [ ] Equipment available
- [ ] Equipment tested and functional
- [ ] Accessories complete
- [ ] Applicant identity verified

### 3.5.2 Issuance Process

1. **Equipment Preparation**
   ```yaml
   Tasks:
     - Select specific equipment units
     - Test functionality
     - Gather accessories
     - Document serial numbers
     - Update inventory status
   ```

2. **Documentation**
   ```php
   $transaction = LoanTransaction::create([
       'loan_application_id' => $application->id,
       'type' => 'issue',
       'transaction_date' => now(),
       'issuing_officer_id' => auth()->id(),
       'accessories_checklist' => $checklist,
       'issue_notes' => $notes,
   ]);
   ```

3. **Handover Process**
   - Verify recipient identity
   - Demonstrate equipment condition
   - Complete accessories checklist
   - Obtain recipient signature
   - Provide return instructions

### 3.5.3 Accessories Checklist

| Equipment Type | Standard Accessories |
|----------------|---------------------|
| **Laptop**

<...to be continued after 5 hour claude limitation>
