<p align="center">
  <img src="https://www.seven.io/wp-content/uploads/Logo.svg" width="250" alt="seven logo" />
</p>

<h1 align="center">seven SMS for Akaunting</h1>

<p align="center">
  Send bulk SMS, place text-to-speech calls and trigger invoice notifications from <a href="https://akaunting.com/">Akaunting</a> via the seven gateway.
</p>

<p align="center">
  <a href="LICENSE"><img src="https://img.shields.io/badge/License-MIT-teal.svg" alt="MIT License" /></a>
  <img src="https://img.shields.io/badge/Akaunting-3.x-blue" alt="Akaunting 3.x" />
  <img src="https://img.shields.io/badge/PHP-8.0%2B-purple" alt="PHP 8.0+" />
</p>

---

## Features

- **Bulk SMS** - Reach all contacts in one go
- **Bulk Voice Calls** - Place text-to-speech calls to contacts
- **Invoice-Triggered SMS** - Auto-notify the associated contact when a new invoice is created

## Prerequisites

- An [Akaunting](https://akaunting.com/) installation
- PHP 8.0+, Composer, Node.js
- A [seven account](https://www.seven.io/) with API key ([How to get your API key](https://help.seven.io/en/developer/where-do-i-find-my-api-key))

## Installation

```bash
cd /path/to/akaunting/modules
git clone https://github.com/seven-io/akaunting.git Seven
cd Seven
composer install
npm install
npm run build
cd ../..
php artisan module:install seven <company_id>
```

## Configuration

In the Akaunting admin go to **Apps > Seven** and paste your seven API key.

## Support

Need help? Feel free to [contact us](https://www.seven.io/en/company/contact/) or [open an issue](https://github.com/seven-io/akaunting/issues).

## License

[MIT](LICENSE)
