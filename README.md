
# Sign Up | Log In (PHP + MySQL)

A complete registration, login, and password recovery system with email verification. Built with **PHP**, using **MySQL**, **CSS**, and **JavaScript**. Protected from XSS attacks and easy to configure.

## Features

```markdown
- Registration with email confirmation (code-based)
- Login protected from XSS
- Password recovery via email
- Uses PHP `mail()` function for email sending
- Simple integration with MySQL (`config.php`)
- Ready-to-use CSS + JavaScript (folder: `resource`)
- Easy and clear setup

```

## Installation

### 1. Clone the repository
```markdown

bash
git clone https://github.com/TheFuZeeXD/RapidAuthPHP.git
```
*If Git is not installed, download the archive from the **Releases** section.*

### 2. Configure the database
- Open the `config.php` file and replace the database credentials with your own.
- Create the database table:
```sql
CREATE TABLE users (
	id INT AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(50) NOT NULL UNIQUE, 
	email VARCHAR(100) NOT NULL UNIQUE,  
	password VARCHAR(255) NOT NULL, 
	reg_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);
```

### 3. Set up email
In the following files, replace `"no-reply@yourdomain.com"` with your actual domain email:
- `registration.php`
- `verify_email.php`
- `enter_code.php`
- `forgot_password.php`

---

## Functionality

### Registration
- Users enter a username, email, and password.
- A code is sent to the email for verification.
- If the email or username already exists, the account won't be created.

### Login
- Login with username and password.
- Protected from XSS attacks.

### Forgot Password
- Enter email to receive a recovery code.
- Enter the code and set a new password.

---

## Project Structure

| File / Folder           | Description |
|-------------------------|-------------|
| `config.php`            | MySQL connection settings |
| `index.php`             | Main page with automatic login via cookies |
| `auth.php`              | UI for registration, login, and password recovery |
| `register.php`          | Handles registration form |
| `verify_email.php`      | Email verification with code |
| `login.php`             | Handles login form |
| `forgot_password.php`   | Handles password reset request |
| `enter_code.php`        | Verifies email with code for password reset |
| `reset_password.php`    | Form to enter a new password |
| `logout.php`            | Logs out the user and clears cookies |
| `/resource/`            | Contains CSS and JavaScript files |

---

## Done!

The system is ready for use and easily integrates into any PHP-based project.

Need help? Just reach out! fuzeexd@thefuzeexd.ru
