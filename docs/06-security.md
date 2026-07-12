# 6. Security Guide

ZyroCart is a learning/project app **not safe for public deployment** as-is. The issues below were identified during code review. Severity reflects exploitability on a deployed instance.

## Findings

| # | Severity | Issue | Location |
|---|----------|-------|----------|
| S1 | 🔴 Critical | **SQL Injection** via raw `$_GET['inputKeyword']` in `LIKE` | `api/products/filter_products.php:8` |
| S2 | 🔴 Critical | **SQL Injection** via raw `$_GET['product_id']` | `api/products/product_detail.php:9` |
| S3 | 🔴 Critical | **SQL Injection** — `name`/`phone` not escaped in UPDATE | `api/auth/update_profile.php:24` |
| S4 | 🔴 Critical | **Arbitrary file upload** — no MIME/extension/size validation → possible RCE | `api/auth/update_profile.php:27-41` |
| S5 | 🟠 High | **SQL Injection** — `price[]` indexes interpolated unescaped | `api/products/get_products.php:14,19` |
| S6 | 🟠 High | **CSRF** — destructive actions via GET (`delete_address`, `delete_account`, `logout`); **no CSRF token anywhere** | `delete_address.php`, `delete_account.php`, `logout.php` |
| S7 | 🟠 High | **Stored/Reflected XSS** — `user_name`/`profile_image` echoed without `htmlspecialchars` | `layouts/header.php:163,168` |
| S8 | 🟠 High | **XSS** — product `name` injected into DOM via JS template strings | `footer.php:111`, `shop.php:208` |
| S9 | 🟡 Medium | **Info leak** — `display_errors`/`E_ALL` left on | `update_profile.php:3-4` |
| S10 | 🟡 Medium | **Weak DB creds** — root with empty password hardcoded | `api/config/db.php:2-4` |
| S11 | 🟢 Low | **Debug leftover** — `console.log` in production search | `footer.php:85` |

## What's Already Good ✅
- Passwords hashed with `password_hash()` / verified with `password_verify()`.
- `login.php` and `register.php` use **prepared statements**.
- Account pages (`profile`, `addresses`, `cart`, `orders`, `wishlist`) escape output with `htmlspecialchars()`.

## Hardening Checklist

- [ ] Replace **all** string-interpolated queries with **prepared statements** (S1–S3, S5).
- [ ] Validate uploaded files server-side: extension allowlist, `getimagesize()`, size cap (S4).
- [ ] Add **CSRF tokens** to every state-changing form/endpoint; convert destructive GETs to POST (S6).
- [ ] Apply `htmlspecialchars()` (with `ENT_QUOTES`) to *all* echoed user/data values, including header (S7, S8).
- [ ] Disable `display_errors` in production; log to a file (S9).
- [ ] Move DB credentials to environment config; use a least-privilege DB user (S10).
- [ ] Remove the `console.log` debug line (S11).
