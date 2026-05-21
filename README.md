

---

```markdown
# 🏥 Online Registration System (ORS) - COVID-19 Testing & Vaccination Management

![PHP Version](https://img.shields.io/badge/PHP-8.0%2B-blue)
![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-orange)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.1-purple)
![License](https://img.shields.io/badge/License-MIT-green)

## 📋 Project Overview

The **Online Registration System (ORS)** is a full-stack web application designed to automate COVID-19 testing and vaccination management across multiple hospitals. It replaces manual paperwork with a centralized digital platform, enabling seamless patient registration, appointment booking, test result tracking, and vaccination status monitoring.

### 🎯 Key Features

| Feature | Description |
|---------|-------------|
| **Role-Based Access** | Three separate panels for Admin, Hospital, and Patient |
| **Hospital Approval Workflow** | Admin approves hospital registrations before access |
| **Vaccine Inventory Management** | Hospitals can add/edit/delete their own vaccines |
| **Request-Approval System** | Patients request tests/vaccinations; hospitals approve |
| **Auto-Appointment Creation** | Appointments auto-created upon request approval |
| **Digital Test Results** | Patients view COVID-19 test results online |
| **Vaccination Status Tracking** | Track vaccination doses and completion status |
| **SMS Notifications** | Mock SMS system for real-time updates |
| **Admin Reports** | Daily/Weekly/Monthly appointment reports (HTML export) |
| **Activity Logging** | Complete audit trail of all user actions |
| **Responsive Design** | Works on desktop, tablet, and mobile devices |

---

## 👥 User Roles & Access

### 👑 Admin
- Login authentication
- View all patients and hospitals
- Approve/reject hospital registrations
- Generate daily/weekly/monthly reports
- View activity logs
- Oversee entire system

### 🏥 Hospital
- Register with admin approval workflow
- Login authentication
- Manage vaccine inventory (CRUD operations)
- View patient requests for tests/vaccinations
- Approve or reject requests
- Auto-create appointments on approval
- Update COVID-19 test results
- Update vaccination status
- View assigned patients

### 👤 Patient
- Register with unique Patient ID
- Login authentication
- Search hospitals by name or city
- Request COVID-19 test
- Request vaccination
- Book appointments
- View appointment history
- View test results online
- Track vaccination status
- Edit profile

---

## 🛠️ Technology Stack

| Layer | Technology | Version |
|-------|------------|---------|
| **Frontend** | HTML5, CSS3, JavaScript, Bootstrap | 5.1 |
| **Icons** | Font Awesome | 6.0 |
| **Backend** | PHP | 8.0+ |
| **Database** | MySQL | 5.7+ |
| **Server** | Apache (XAMPP/WAMP/LAMP) | - |
| **Security** | PDO Prepared Statements, password_hash() | - |

---

## 📂 Project Structure

```
ors/
├── admin/                 # Admin Panel (dashboard, hospitals, patients, approvals, reports)
├── hospital/              # Hospital Panel (dashboard, requests, vaccines, results, patients)
├── patient/               # Patient Portal (dashboard, test requests, appointments, results)
├── auth/                  # Authentication (login, register for all roles)
├── config/                # Configuration (database, constants)
├── includes/              # Reusable components (header, footer, functions)
├── api/                   # API endpoints (appointment submission)
├── uploads/               # File uploads (reports)
├── index.php              # Landing page
├── about.php              # About page
├── contact.php            # Contact form
├── appointment.php        # Quick appointment booking
├── database.sql           # Database schema
└── .htaccess              # Apache configuration
```

---

## 🗄️ Database Schema

**Database Name:** `ors_system`

| Table | Description |
|-------|-------------|
| `admins` | System administrator accounts |
| `hospitals` | Hospital registrations with approval status |
| `patients` | Patient accounts with unique IDs |
| `vaccines` | Hospital-specific vaccine inventory |
| `covid_tests` | COVID-19 test requests and results |
| `vaccinations` | Vaccination records and status |
| `appointments` | Appointment bookings |
| `requests` | Approval workflow for tests/vaccinations |
| `sms_logs` | SMS notification logs |
| `activity_logs` | User activity audit trail |

---

## 🚀 Installation Guide

### Prerequisites

- XAMPP / WAMP / LAMP installed
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache with mod_rewrite enabled

### Step-by-Step Installation

```bash
# 1. Clone the repository
git clone https://github.com/yourusername/ors-covid-portal.git
# or copy files to htdocs/med/

# 2. Move to project directory
cd ors-covid-portal

# 3. Copy to XAMPP htdocs
cp -r * /xampp/htdocs/med/

# 4. Create database
# Open phpMyAdmin → Create database 'ors_system'

# 5. Import SQL
# Import database.sql file into phpMyAdmin

# 6. Configure database
# Edit config/config.php with your database credentials

# 7. Start servers
# Start Apache and MySQL in XAMPP Control Panel

# 8. Access application
# Open browser and go to http://localhost/med/
```

### Configuration File (`config/config.php`)

```php
define('SITE_URL', 'http://localhost/med/');
define('DB_HOST', 'localhost');
define('DB_NAME', 'ors_system');
define('DB_USER', 'root');
define('DB_PASS', '');
```

---

## 🔐 Default Login Credentials

| Role | Username/Email | Password |
|------|----------------|----------|
| **Admin** | admin@ors.com | Admin@123 |
| **Hospital** | citygeneral@hospital.com | Admin@123 |
| **Patient** | john@example.com | Patient@123 |

---

## 📸 Screenshots

### Homepage
![Homepage](screenshots/homepage.png)

### Admin Dashboard
![Admin Dashboard](screenshots/admin-dashboard.png)

### Hospital Dashboard
![Hospital Dashboard](screenshots/hospital-dashboard.png)

### Patient Dashboard
![Patient Dashboard](screenshots/patient-dashboard.png)

### Manage Vaccines (Hospital)
![Manage Vaccines](screenshots/manage-vaccines.png)

### Patient Request Approval
![Request Approval](screenshots/request-approval.png)

---

## 🔄 Workflow Diagrams

### Patient Request Flow
```
Patient → Login → Select Hospital → Request Test/Vaccination 
→ Hospital Approves → Auto-Create Appointment → Patient Attends 
→ Hospital Updates Results → Patient Views Online
```

### Hospital Vaccine Management
```
Hospital → Login → Manage Vaccines → Add/Edit/Delete Vaccine 
→ Update Stock → Mark Availability → Patient Sees Available Vaccines
```

### Admin Report Generation
```
Admin → Login → Reports → Select Type (Daily/Weekly/Monthly) 
→ Select Date → Generate Report → View Table → Export HTML
```

---

## 📊 Reports

| Report Type | Description | Export Format |
|-------------|-------------|---------------|
| Daily | Appointments for specific date | HTML |
| Weekly | Appointments for 7-day period | HTML |
| Monthly | Appointments for entire month | HTML |

---

## 📱 Responsive Design

| Device | Breakpoint | Status |
|--------|------------|--------|
| Desktop | ≥992px | ✅ Fully Supported |
| Tablet | 768px - 991px | ✅ Fully Supported |
| Mobile | ≤767px | ✅ Fully Supported |

---

## 🔒 Security Features

| Feature | Implementation |
|---------|----------------|
| SQL Injection | PDO Prepared Statements |
| Password Security | password_hash() / password_verify() |
| XSS Protection | htmlspecialchars() sanitization |
| Session Security | Session-based authentication |
| Role-Based Access | checkRole() function |
| Activity Logging | All actions logged with IP |
| CSRF Protection | Session validation |

---

## 📝 API Endpoints

| Endpoint | Method | Purpose |
|----------|--------|---------|
| `api/submit-request.php` | POST | Book appointment (AJAX) |
| `api/get-hospital-details.php` | POST | Fetch hospital info |
| `api/get-vaccines.php` | POST | Fetch hospital vaccines |

---

## 🧪 Testing

### Test Accounts

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@ors.com | Admin@123 |
| Hospital | citygeneral@hospital.com | Admin@123 |
| Patient | john@example.com | Patient@123 |

### Test Workflow

1. **Patient Registration** → Create new patient account
2. **Request Test** → Submit COVID-19 test request
3. **Hospital Login** → Approve request
4. **Appointment Created** → Auto-generated
5. **Update Results** → Hospital updates test result
6. **Patient View** → Patient sees result online

---

## ❗ Common Issues & Solutions

| Issue | Solution |
|-------|----------|
| `Column not found: hospital_id` | Run ALTER TABLE vaccines ADD COLUMN hospital_id VARCHAR(50) |
| `Failed to open stream: sidebar.php` | Create sidebar.php or remove include |
| `Cannot modify header information` | Ensure no output before session_start() |
| `404 Not Found` | Check SITE_URL in config/config.php |
| `Access denied for user` | Verify database credentials |

---

## 👨‍💻 Developer Information

- **Author:** Noor us Saba
- **Course:** eProject
- **Technologies:** PHP, MySQL, Bootstrap, HTML, CSS, JavaScript
- **Database:** MySQL (10 tables)
- **Total Files:** 50+ PHP files
- **Development Time:** 18 days

---

## 📄 License

This project is for educational purposes. MIT License.

---

## 🤝 Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/amazing`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push to branch (`git push origin feature/amazing`)
5. Open Pull Request

---

## 📧 Contact

For support or queries:
- **Email:** nooorkha4455@gmail.com

---

## 🙏 Acknowledgements

- Project Guide and Faculty Members
- BootstrapMade for design inspiration
- Font Awesome for icons
- Open-source community

---

## ⭐ Show Your Support

If this project helped you, please give it a ⭐ on GitHub!

---

**Made with ❤️ for COVID-19 Healthcare Management**
```

---

## 📋 GITHUB REPOSITORY SETTINGS

### Repository Name
```
ORS-COVID19-Vaccination-Management-System
```
or
```
online-registration-system-covid
```

### Short Description (max 350 characters)
```
🏥 Online Registration System for COVID-19 Testing & Vaccination Management. Full-stack PHP/MySQL web app with Admin, Hospital & Patient panels. Features appointment booking, vaccine inventory, test results, SMS notifications & reports.
```

### Topics (Tags)
```
php, mysql, covid-19, healthcare, hospital-management, vaccination-system, appointment-booking, test-results, bootstrap, web-application, full-stack, role-based-access
```

### Website URL
```
http://localhost/med/
```

---

## 📁 ADDITIONAL FILES TO CREATE

### `.gitignore`
```
# System files
.DS_Store
Thumbs.db

# IDE files
.vscode/
.idea/
*.sublime-*

# Logs
*.log
error_log

# Uploads (but keep folder)
uploads/reports/*.xlsx
!uploads/reports/.gitkeep

# Config (if you have sensitive data)
# config/config.php - but keep template
```

### `screenshots/` folder
Create this folder and add:
- `homepage.png`
- `admin-dashboard.png`
- `hospital-dashboard.png`
- `patient-dashboard.png`
- `manage-vaccines.png`
- `request-approval.png`
- `reports.png`

### `LICENSE` file
```txt
MIT License

Copyright (c) 2025 Noor us Saba

Permission is hereby granted, free of charge, to any person obtaining a copy...
```

---

## 🎯 FINAL CHECKLIST BEFORE UPLOADING

| Task | Status |
|------|--------|
| Remove database passwords from config | ☐ |
| Add .gitignore file | ☐ |
| Add README.md | ☐ |
| Add LICENSE file | ☐ |
| Add screenshots folder | ☐ |
| Remove localhost-specific paths | ☐ |
| Test on fresh XAMPP install | ☐ |
| Push to GitHub | ☐ |

