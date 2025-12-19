# PHP_Laravel12_Session

A clean and simple Laravel 12 application demonstrating **basic session management** using Laravel’s built-in session system.

This project is ideal for **learning, interviews, assignments, and quick reference**.

---

## Project Overview

This repository explains how Laravel 12 handles session management using three core operations:

1. Store data in the session
2. Retrieve data from the session
3. Remove data from the session

It uses Laravel’s default **file-based session driver**, making it easy to understand without additional configuration.

---

## Features

* Set session data
* Get session data
* Remove session data
* File-based session storage
* Clean and minimal code structure

---

## Prerequisites

* PHP 8.1 or higher
* Composer
* Laravel 12
* Apache, Nginx, or PHP built-in server

---

## Project Screenshots

<img src="https://github.com/user-attachments/assets/ca9cec66-ebef-4e51-a018-f082eda6d311" />
<img src="https://github.com/user-attachments/assets/ffe598b3-5e9e-480b-8fe3-716e9a7ba7ce" />
<img src="https://github.com/user-attachments/assets/80b7f3c3-9884-4029-b2c6-edc674775875" />
<img src="https://github.com/user-attachments/assets/1eb8b910-134d-46fb-80fe-618eecceb366" />

---

## Installation Guide

### Step 1: Clone the Repository

```bash
git clone https://github.com/your-github-username/laravel-session-demo.git
cd laravel-session-demo
```

### Step 2: Install Dependencies

```bash
composer install
```

### Step 3: Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

---

## Session Configuration

Ensure the following values exist in your `.env` file:

```env
SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
```

Session files are stored at:

```
storage/framework/sessions
```

---

## Project Structure

```
laravel-session-demo/
├── app/
│   └── Http/
│       └── Controllers/
│           └── SessionController.php
├── routes/
│   └── web.php
├── config/
│   └── session.php
├── storage/
│   └── framework/
│       └── sessions/
├── .env
├── .env.example
└── README.md
```

---

## Code Implementation

### 1. Session Controller

File: `app/Http/Controllers/SessionController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function accessSessionData(Request $request)
    {
        if ($request->session()->has('my_name')) {
            return response($request->session()->get('my_name'), 200);
        }

        return response('No data in the session', 200);
    }

    public function storeSessionData(Request $request)
    {
        $request->session()->put('my_name', 'Virat Gandhi');

        return response('Data has been added to session', 200);
    }

    public function deleteSessionData(Request $request)
    {
        $request->session()->forget('my_name');

        return response('Data has been removed from session.', 200);
    }
}
```

---

### 2. Routes

File: `routes/web.php`

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;

Route::get('/session/set', [SessionController::class, 'storeSessionData']);
Route::get('/session/get', [SessionController::class, 'accessSessionData']);
Route::get('/session/remove', [SessionController::class, 'deleteSessionData']);
```

---

## API Endpoints

| Method | Endpoint        | Description           |
| ------ | --------------- | --------------------- |
| GET    | /session/set    | Store session data    |
| GET    | /session/get    | Retrieve session data |
| GET    | /session/remove | Delete session data   |

---

## Usage

Start the development server:

```bash
php artisan serve
```

Visit the following URLs in your browser:

```
http://localhost:8000/session/set
http://localhost:8000/session/get
http://localhost:8000/session/remove
```

Flow:

```
/session/set → /session/get → /session/remove → /session/get
```

---

## Final Notes

This project is intentionally kept simple to clearly demonstrate session concepts in Laravel 12.

It is perfect for:

* Beginners learning Laravel sessions
* Interview preparation
* Academic assignments
* Quick revision before exams

You can easily extend this project to store user authentication data, shopping cart sessions, or flash messages.
