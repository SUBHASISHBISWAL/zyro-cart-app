# Changelog

All notable changes are derived from the Git history of `zyro-cart-app` (branch `staging`).

Format based on [Keep a Changelog](https://keepachangelog.com/).

## [Unreleased]
- Reconstructed canonical DB schema for `users`, `shop_products`, `user_addresses`, `price_ranges`, `colors` (only `cart` was committed).
- Documentation suite added under `docs/`.

## [0.7.0] - 2026-04-14
### Added
- Dynamic product rendering from database (`790cd5b`).

## [0.6.0] - 2026-04-08
### Changed
- Multiple shop/filter page revisions and conflict resolutions (`5568912`, `c92d659`, `21286a5`, `c832458`, `ad6e3e9`).

## [0.5.0] - 2026-04-04
### Changed
- Profile section UI redesign (`4523218`).

## [0.4.0] - 2026-04-02
### Added
- Dynamic AJAX cart with live calculations and shop-page add-to-cart fix (`a34cb46`).

## [0.3.0] - 2026-03-31
### Added
- Full-stack Address Management system (`d1b776f`).
- Shop detail page (`8726b4b`).
### Changed
- Header updates (`ab955b2`, `3406b5f`).

## [0.2.0] - 2026-03-24 → 2026-03-30
### Added
- User auth UI in header, logout (`31a4165`).
- Professional footer with contact info (`4862b16`).
- User Profile and My Orders pages with sidebar (`c4822bc`).
- SweetAlert2 account-deletion flow and dashboard polish (`746f623`).
- Wishlist link added to header dropdown; DB path fix in profile update (`4001955`).

## [0.1.0] - 2026-03-23
### Added
- Initial commit / project scaffold (`bcd6cb9`).
- Login page (`112284c`).
- Header styling and color updates (`b766f5b`, `3f84e64`, `ec73b1e`, `a07ef3e`).
- FAQs, Help, Support pages linked in header (`1620496`).
