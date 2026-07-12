# ZyroCart — Documentation

> A PHP + MySQL e-commerce storefront built on the EShopper Bootstrap template, extended with a dynamic catalog, AJAX cart, authentication, and address management.

[![PHP](https://img.shields.io/badge/PHP-8.0-777BB4?logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?logo=mysql&logoColor=white)](https://www.mysql.com/)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-4.4.1-7952B3?logo=bootstrap&logoColor=white)](https://getbootstrap.com/)
[![License](https://img.shields.io/badge/License-EShopper_Template_LICENSE-blue)](../LICENSE.txt)

## Documentation Index

| Document | Description |
|----------|-------------|
| [1. Overview](docs/01-overview.md) | What the project is, tech stack, and feature list |
| [2. Architecture](docs/02-architecture.md) | Directory layout, request flow, and design patterns |
| [3. Data Model](docs/03-data-model.md) | Database tables, relationships, and the schema gap |
| [4. Setup & Installation](docs/04-setup.md) | Run it locally on XAMPP step-by-step |
| [5. API Reference](docs/05-api-reference.md) | Every endpoint: method, auth, params, response |
| [6. Security Guide](docs/06-security.md) | Known vulnerabilities and hardening checklist |
| [7. Roadmap & Limitations](docs/07-roadmap.md) | Stubbed features and planned work |
| [Changelog](docs/CHANGELOG.md) | Version history derived from the Git log |

## Quick Start

```bash
# 1. Clone into your XAMPP htdocs
git clone <repo-url> ecommerce-app

# 2. Create the database `zyrocart` in phpMyAdmin and import the schema
#    (see docs/03-data-model.md for the full DDL)

# 3. Start Apache + MySQL in XAMPP, then open:
#    http://localhost/ecommerce-app/
```

> ⚠️ **Not production-ready.** See [Security Guide](docs/06-security.md) before any public deployment.
