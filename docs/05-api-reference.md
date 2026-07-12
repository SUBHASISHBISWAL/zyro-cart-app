# 5. API Reference

All endpoints live under `api/` and use **procedural PHP**. Auth state is tracked via `$_SESSION['user_id']`. Most return JSON; auth form endpoints return a redirect.

> 🔴 Several endpoints below are vulnerable to SQL injection / CSRF. See [Security Guide](06-security.md).

## Auth

| Endpoint | Method | Auth | Purpose |
|----------|--------|------|---------|
| `api/auth/register.php` | POST | Public | Create account (prepared stmt ✅) |
| `api/auth/login.php` | POST | Public | Login (prepared stmt ✅) |
| `api/auth/logout.php` | GET | Any | Destroy session → redirect home |
| `api/auth/update_profile.php` | POST | User | Update name/phone + upload image |
| `api/auth/delete_account.php` | GET | User | Delete own account |
| `api/auth/save_address.php` | POST | User | Insert address |
| `api/auth/delete_address.php` | GET | User | Delete address by `?id=` |

**Login** `POST api/auth/login.php`
```
email, password  →  session set, redirect ../../index.php
```
**Update profile** `POST api/auth/update_profile.php`
```
name, phone, [profile_image file]  →  redirect ../../pages/profile.php
⚠️ name/phone not escaped; file upload unvalidated
```

## Cart

| Endpoint | Method | Auth | Purpose |
|----------|--------|------|---------|
| `api/cart/add_to_cart.php` | POST | User | Add/increment item, returns `cart_count` |
| `api/cart/update_cart.php` | POST | User | Set quantity for `cart_id` |
| `api/cart/remove_cart.php` | POST | User | Delete item, returns `cart_count` |

**Add to cart** `POST api/cart/add_to_cart.php`
```json
// request
{ "product_id": 12, "qty": 1, "size": "", "color": "" }
// response
{ "status": "success", "message": "Product added to cart!", "cart_count": 3 }
```

## Products

| Endpoint | Method | Auth | Purpose |
|----------|--------|------|---------|
| `api/products/get_products.php` | GET | Public | List products; supports `cat`, `price[]` |
| `api/products/product_detail.php` | GET | Public | Single product by `?product_id=` |
| `api/products/filter_products.php` | GET | Public | Live search by `?inputKeyword=` |

**Get products** `GET api/products/get_products.php?cat=shoes`
```json
[ { "id": 1, "name": "...", "price": "499.00", "image_url": "[\"..\"]" }, ... ]
```
⚠️ `price[]` indexes are interpolated unescaped; `color`/`size` params sent by `shop.php` are **ignored server-side**.

**Search** `GET api/products/filter_products.php?inputKeyword=shirt`
```sql
-- backend builds: WHERE name LIKE '%<inputKeyword>%'   ⚠️ SQLi, no escaping
```
