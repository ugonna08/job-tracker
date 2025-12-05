# Job Tracker

A simple job and internship tracking web application that helps users stay organized during their job search.  
Built using **PHP**, **MySQL**, **HTML/CSS**, and designed as a beginner-friendly full-stack project.

---

## 🚀 Features

### 🔐 Authentication
- User registration & login  
- Secure password hashing (`password_hash`)  
- Session-based authentication  

### 📋 Job Management
- Add new job applications  
- Edit existing applications  
- Delete applications  
- Track:
  - Company  
  - Position  
  - Status (Applied, Interviewing, Offer, Rejected)  
  - Applied date  
  - Notes  

### 🎨 UI / UX
- Dark-themed, consistent styling  
- Clean dashboard layout  
- Simple and efficient UI

---

## 🛠️ Tech Stack

- **PHP 8+**
- **MySQL**
- **HTML/CSS**
- **Basic JavaScript**
- **XAMPP (Apache + MySQL)** — Required for local development

---

## 📁 Folder Structure

job-tracker/
│
├── public/
│ ├── dashboard.php
│ ├── delete_job.php
│ ├── edit_job.php
│ ├── login.php
│ ├── logout.php
│ └── register.php
│
├── sql/
│ └── jobtracker.sql
│
├── src/
│ └── db.php
│
└── README.md

---

## ⚙️ Installation & Setup

### **1. Install XAMPP**
Download and install XAMPP from the official website.  
Make sure **Apache** and **MySQL** are running.

### **2. Clone the Repository**
```bash
git clone https://github.com/<your-username>/job-tracker.git

### **3. Move Project Into XAMPP**
Place the project folder inside:
xampp/htdocs/

### **4. Import the Database**
Open phpMyAdmin
Create a database named:
jobtracker
Go to Import
Upload sql/jobtracker.sql

### **5. Configure Database Connection**
Open src/db.php and verify your MySQL credentials:
$pdo = new PDO("mysql:host=localhost;dbname=jobtracker", "root", "");

### **6. Run the Application**
Visit this in your browser:
http://localhost/job-tracker/public/login.php
