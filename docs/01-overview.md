# 1. Overview

ZyroCart is a multi-page e-commerce front end written in **procedural PHP** with a **MySQL** backend, styled with **Bootstrap 4** and **jQuery**. It began as the open-source *EShopper* HTML template and was progressively turned into a data-driven store.

## Tech Stack

| Concern | Technology |
|---------|------------|
| Server | PHP 8.x (procedural, no framework) |
| Database | MySQL via `mysqli` (mixed OOP + procedural) |
| Styling | Bootstrap 4.4.1, custom SCSS, Owl Carousel |
| Interactivity | jQuery 3.4/3.6, SweetAlert2, AJAX |
| Hosting | XAMPP (Apache + MySQL) on `localhost` |
| Source control | Git (branch `staging`, remote `SUBHASISHBISWAL/zyro-cart-app`) |

## Feature Matrix

| Feature | Status | Notes |
|---------|--------|-------|
| User registration / login / logout | ✅ Working | `password_hash` / `password_verify` |
| Profile edit + image upload | ✅ Working | No server-side file validation |
| Address CRUD | ✅ Working | Add / list / delete |
| Product catalog (grid + filters) | ✅ Working | Price & color filters; size filter UI-only |
| Product search | ✅ Working | AJAX live search in header |
| AJAX cart (add / update / remove) | ✅ Working | Live badge count |
| Checkout | ⛔ Stub | Static HTML, no order placement |
| Order history | ⛔ Stub | Hardcoded "No Orders Yet" |
| Wishlist | ⛔ Stub | Hardcoded "Empty" |
| Contact form | 🟡 Partial | `assets/mail/contact.php` present |

## Project Naming

Note three names in play — keep them distinct:
- **Folder:** `ecommerce-app`
- **Git repo:** `zyro-cart-app`
- **Brand:** `ZyroCart`
