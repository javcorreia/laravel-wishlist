# Changelog

All notable changes to this project will be documented in this file.

This project follows [Keep a Changelog](https://keepachangelog.com/) and adheres to [Semantic Versioning](https://semver.org/).

## [Unreleased]
- [2025-11-16] changes on README.md for better clarity on older versions and their support status

---

## [5.0] - 2026-04-02

### Added
- added support for Laravel 13
- added support for PHP >=8.3
- updated composer dev packages:
  - `orchestra/testbench` to `^11.0`
  - `pestphp/pest` to `^4.1`

### Removed
- removed support for Laravel 11 and 12
- removed support for PHP <=8.2

---

## [4.1.1] - 2025-08-28

### Added
- added `.gitattributes` file for more streamlined releases
- Added `PATCH` to versioning scheme, now following [Semantic Versioning](https://semver.org/) guidelines
- added [`.editorconfig`](https://editorconfig.org/) file for consistent coding style

---

## [4.1] - 2025-08-28

### Added
- Added static analysis via **phpstan** 
    - level 5 compliance
- Support for **Laravel 12**
- `DOCS.md` file for technical documentation
- **Laravel Pint** as linter

---

## [4.0] - 2024-09-03

### Added
- Support for **Laravel 11**
- Enforced PHP requirement `^8.1`

---

## [3.1] - 2023-02-20

### Changed
- QOL: changed project composer description

---

## [3.0] - 2023-02-20

### Added
- Support for **Laravel 10**
- Enforced PHP requirement `^8.0`

---

## [2.2] - 2022-07-29

### Added
- Support for **Laravel 9**

---

## [2.0] - 2022-07-29

### Added
- Added support to Laravel versions **5.8 | 6.\* | 7.\* | 8.\***
- Added the ability to extend the Wishlist model to add soft delete support

### Fixed
- Fixed a mismatch between facade namespace and compose.json alias

---

## [1.3] - 2019-01-25

### Added
- Initial fork of [bhavinjir lib](https://github.com/bhavinjr/laravel-wishlist)
- Added session wishlist support
  - wishlists can now be added to a session id, to allow anonymous wishlisting

---

## [1.2.* / earlier versions]

See [bhavinjir's lib](https://github.com/bhavinjr/laravel-wishlist) for info on earlier releases.
