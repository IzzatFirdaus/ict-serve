Dokumentasi_Jadual_Data_Pengguna_Organisasi_Teras_ICTServe(iServe).md
Database Schema Documentation - ICTServe (iServe) v1.0
Document Information

Version: 1.0
Last Updated: September 2025
Document Type: Database Technical Documentation
Audience: Database Administrators, Backend Developers, System Architects

Table of Contents

Database Overview
Core User & Organization Tables
ICT Equipment Management Tables
Loan Management Tables
Helpdesk Support Tables
Workflow & Utility Tables
Database Relationships
Indexes and Performance
Data Integrity and Constraints
Migration Strategy

1. Database Overview
1.1 Database Architecture

Database System: MySQL 8.0+
Character Set: utf8mb4
Collation: utf8mb4_unicode_ci
Storage Engine: InnoDB
Timezone: Asia/Kuala_Lumpur

1.2 Design Principles

Normalization: 3NF (Third Normal Form) compliance
Audit Trail: Comprehensive tracking via created_by, updated_by, deleted_by
Soft Deletes: Preservation of historical data
UUID Support: For distributed system compatibility
JSON Fields: For flexible metadata storage

1.3 Naming Conventions
TypeConventionExampleTablesPlural, snake_caseusers, loan_applicationsColumnsSingular, snake_caseuser_id, created_atPrimary Keysidid (BIGINT UNSIGNED)Foreign Keys{table}_iduser_id, department_idIndexesidx_{table}_{columns}idx_users_emailConstraintsfk_{table}_{column}fk_users_department
2. Core User & Organization Tables
2.1 users
Primary table for system user accounts and authentication.
sqlCREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(20) NULL,
    name VARCHAR(255) NOT NULL,
    identification_number VARCHAR(20) UNIQUE NOT NULL,
    passport_number VARCHAR(20) NULL,
    profile_photo_path VARCHAR(2048) NULL,
    position_id BIGINT UNSIGNED NULL,
    grade_id BIGINT UNSIGNED NULL,
    department_id BIGINT UNSIGNED NULL,
    level VARCHAR(10) NULL,
    mobile_number VARCHAR(20) NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    two_factor_secret TEXT NULL,
    two_factor_recovery_codes TEXT NULL,
    two_factor_confirmed_at TIMESTAMP NULL,
    remember_token VARCHAR(100) NULL,
    created_by BIGINT UNSIGNED NULL,
    updated_by BIGINT UNSIGNED NULL,
    deleted_by BIGINT UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    INDEX idx_users_email (email),
    INDEX idx_users_identification (identification_number),
    INDEX idx_users_department (department_id),
    INDEX idx_users_status (status),
    FOREIGN KEY fk_users_position (position_id) REFERENCES positions(id),
    FOREIGN KEY fk_users_grade (grade_id) REFERENCES grades(id),
    FOREIGN KEY fk_users_department (department_id) REFERENCES departments(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
Key Fields:

identification_number: Malaysian IC or passport number
status: Account status for access control
two_factor_*: 2FA implementation fields
Audit fields track all modifications

2.2 departments
Organizational structure including headquarters and state offices.
sqlCREATE TABLE departments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    branch_type ENUM('headquarters', 'state_office', 'unit') NOT NULL,
    code VARCHAR(20) UNIQUE NOT NULL,
    description TEXT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    head_user_id BIGINT UNSIGNED NULL,
    parent_id BIGINT UNSIGNED NULL,
    created_by BIGINT UNSIGNED NULL,
    updated_by BIGINT UNSIGNED NULL,
    deleted_by BIGINT UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    INDEX idx_departments_code (code),
    INDEX idx_departments_active (is_active),
    INDEX idx_departments_parent (parent_id),
    FOREIGN KEY fk_departments_head (head_user_id) REFERENCES users(id),
    FOREIGN KEY fk_departments_parent (parent_id) REFERENCES departments(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
2.3 positions
Job positions and titles within MOTAC.
sqlCREATE TABLE positions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    grade_id BIGINT UNSIGNED NULL,
    description TEXT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_by BIGINT UNSIGNED NULL,
    updated_by BIGINT UNSIGNED NULL,
    deleted_by BIGINT UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    INDEX idx_positions_grade (grade_id),
    INDEX idx_positions_active (is_active),
    FOREIGN KEY fk_positions_grade (grade_id) REFERENCES grades(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
2.4 grades
Organizational grades with hierarchical approval levels.
sqlCREATE TABLE grades (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    level INT NOT NULL,
    min_approval_grade_id BIGINT UNSIGNED NULL,
    is_approver_grade BOOLEAN DEFAULT FALSE,
    created_by BIGINT UNSIGNED NULL,
    updated_by BIGINT UNSIGNED NULL,
    deleted_by BIGINT UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    INDEX idx_grades_level (level),
    INDEX idx_grades_approver (is_approver_grade),
    FOREIGN KEY fk_grades_min_approval (min_approval_grade_id) REFERENCES grades(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
2.5 Role and Permission Tables (Spatie Laravel Permission)
sqlCREATE TABLE roles (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(125) NOT NULL,
    guard_name VARCHAR(125) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

<... continued after Claude reset>
