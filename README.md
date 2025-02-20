# SQL Injection Testing Guide

## Introduction
This repository contains a vulnerable website to demonstrate SQL Injection. It runs in a Docker container.

---

## Prerequisites
Before you begin, ensure you have:
- Docker installed on Windows or Ubuntu.
- Clone or download this repository
---

## Setup Instructions
### 1. Start the Docker Containers
Run the following command inside the project directory:
```sh
cd C:\[your own folder]  # Change directory (Windows)
dir # Check that the folder contains files and folders from this repository (Windows)
# or
cd ~/[your own folder]  # Change directory (Linux)
ls # Check that the folder contains files and folders from this repository (Linux)


docker-compose up -d  # Start containers
```
This will start both the **MariaDB** and **Apache/PHP** containers.

### 2. Access the Vulnerable Login Page
Open your web browser and go to:
```
http://localhost:8080/login.php
```
You should see a basic login form with **username** and **password** fields.

Two users exist in the database:
admin - admin123
user1 - letmein

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

## Disclaimer
This setup is for **educational purposes only**. Do not use SQL injection on unauthorized systems.

## Author
Raul Alejandro Vargas Acosta (alejandro.vargas@erau.edu)
