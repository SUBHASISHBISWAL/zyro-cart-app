# 7. Roadmap & Limitations

## Known Limitations (current state)

| Area | Limitation |
|------|-----------|
| Checkout | `checkout.php` is static HTML; no `<form action>`, no `place_order` API |
| Orders | Hardcoded "No Orders Yet" — no `orders` table or query |
| Wishlist | Hardcoded "Empty" — no `wishlist` table or API |
| Size filter | Sidebar size checkboxes exist but `get_products.php` ignores them |
| Schema | Only `cart` table is committed; rest reverse-engineered |
| DB connection | Opened up to twice per request via header re-include |
| Libraries | jQuery (3.4 & 3.6) and Bootstrap (4.4 & 5.3) both loaded → conflicts |
| Assets | Three background PNGs ≈ 9–10 MB each; `style.css` used instead of `style.min.css` |
| Repo hygiene | No `.gitignore`; user uploads committed under `assets/img/users/` |

## Proposed Roadmap

### v0.8 — Stability & Security
- [ ] Fix all SQL injection / CSRF / XSS issues (see [Security Guide](06-security.md))
- [ ] Centralize DB connection, remove double-connect
- [ ] Commit canonical schema + seed data

### v0.9 — Complete the Purchase Flow
- [ ] `orders` + `wishlist` tables and APIs
- [ ] Wire `checkout.php` → `place_order`; show real order history
- [ ] Functional wishlist add/remove

### v1.0 — Polish
- [ ] Optimize images; serve `style.min.css`; dedupe jQuery/Bootstrap
- [ ] Add `.gitignore`; purge committed uploads from history
- [ ] Introduce a light router / shared helpers (optional refactor)
