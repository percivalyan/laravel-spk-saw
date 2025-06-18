# Laravel SPK

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![Laravel Version](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-8.2.12-777BB4.svg)](https://php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-Compatible-yellow.svg)](https://www.mysql.com/)


## Features

- Login
- Create, Edit & Delete User
- Create, Edit & Delete Role
- Create, Edit & Delete Permission

## Technology Stack

- Laravel 12 Framework
- MySQL Database
- PHP 8.2+
- Composer 2.8+

## Prerequisites

- PHP 8.2.12 or higher
- Composer 2.8.6 or higher
- MySQL 5.7+ or MariaDB 10.3+
- XAMPP/WAMP/LAMP (optional)

## Installation

### Clone the repository
```bash
git clone {{this repository}}
```
```bash
cd laravel-spk-saw
```

### Install PHP dependencies
```bash
composer install
```

### Setup environment
```bash
cp .env.example .env
```
or
```bash
copy .env.example .env
```
```bash
php artisan key:generate
```

### Configure database (edit .env file with your credentials)
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=Your Name Database
DB_USERNAME=Your Username
DB_PASSWORD=Your Password
```

### Run migrations and seeders
```bash
php artisan migrate --seed
```

### Start development server
```bash
php artisan serve
```

### Journal List Tested
#### SIMPLE ADDITIVE WEIGHTING
```bash
https://jurnal.lldikti4.or.id/index.php/jurnaltekno/article/download/71/65/
```

#### WEIGHTED PRODUCT
```bash

```
