<img alt="" src="https://www.seven.io/wp-content/uploads/Logo.svg" width="250" />

# seven Module

This module allows sending SMS and making text-to-speech calls
via [seven](https://www.seven.io/).

## Installation

- Open up a terminal and change directory to the `modules` directory inside of your akaunting installation
- Clone the repository: `git clone https://github.com/seven-io/akaunting.git Seven`
- Install dependencies: `cd Seven && composer install && npm i && npm run build`
- Install the module: `cd ../../ && php artisan module:install seven <company_id>`

### Functionalities
- Send bulk SMS to contacts
- Make bulk text-to-speech calls to contacts
- Send SMS on invoice creation to associated contact

#### Support

Need help? Feel free to [contact us](https://www.seven.io/en/company/contact/).

[![MIT](https://img.shields.io/badge/License-MIT-teal.svg)](LICENSE)
