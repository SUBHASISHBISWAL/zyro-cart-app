# 4. Setup & Installation

Tested on **XAMPP for Windows** with Apache + MySQL.

## Prerequisites
- PHP 8.x with `mysqli` enabled
- MySQL / MariaDB
- A web root (e.g. `C:\xampp\htdocs\`)

## Steps

1. **Place the project**
   ```bash
   cd C:\xampp\htdocs
   git clone <repo-url> ecommerce-app
   ```

2. **Start services** — launch XAMPP Control Panel and start **Apache** + **MySQL**.

3. **Create the database**
   - Open `http://localhost/phpmyadmin`
   - Create database **`zyrocart`** (utf8mb4)
   - Import the canonical schema from [Data Model](03-data-model.md) (or expand `api/database/database.sql`).

4. **Configure credentials** — `api/config/db.php` currently uses:
   ```php
   $host = "localhost"; $user = "root"; $pass = ""; $db = "zyrocart";
   ```
   Change the password (root has none by default) and consider a dedicated DB user.

5. **Visit the app**
   ```
   http://localhost/ecommerce-app/
   ```

## Troubleshooting

| Symptom | Fix |
|---------|-----|
| Blank page on sub-pages | Ensure `$base = '../';` is set before including `header.php` |
| Cart count / avatar missing | Confirm `users`/`cart` tables exist and DB creds are correct |
| Images broken | Verify `assets/img/users/` is writable for profile uploads |
| `console.log` spam in search | Expected debug line in `footer.php`; see Security Guide |
