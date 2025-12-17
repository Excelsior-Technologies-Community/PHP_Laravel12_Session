# PHP_Laravel12_Session

A clean and simple Laravel 12 application demonstrating **basic session management** using Laravel’s built-in session system.

This project is ideal for **learning, interviews, assignments, and quick reference**.

---

## ✦ Features

- Set session data  
- Get session data  
- Remove session data  
- File-based session storage  
- Clean and minimal code structure  

---

## ✦ Project Overview

This project demonstrates how Laravel 12 handles session management using three core operations:

1. Store data in session  
2. Retrieve data from session  
3. Remove data from session  

---

## ✦ Prerequisites

- PHP 8.1 or higher  
- Composer  
- Laravel 12  
- Apache / Nginx or PHP built-in server  

---

## ✦ Screenshots

> Application output examples

![Session Set](https://github.com/user-attachments/assets/ca9cec66-ebef-4e51-a018-f082eda6d311)
![Session Get](https://github.com/user-attachments/assets/ffe598b3-5e9e-480b-8fe3-716e9a7ba7ce)
![Session Remove](https://github.com/user-attachments/assets/80b7f3c3-9884-4029-b2c6-edc674775875)
![Session Empty](https://github.com/user-attachments/assets/1eb8b910-134d-46fb-80fe-618eecceb366)

---

## ✦ Installation

Clone the repository:

```bash
git clone https://github.com/your-github-username/laravel-session-demo.git
cd laravel-session-demo
Install dependencies:

bash
Copy code
composer install
Create environment file and generate app key:

bash
Copy code
cp .env.example .env
php artisan key:generate
✦ Session Configuration
Ensure the following values exist in your .env file:

env
Copy code
SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
Session files are stored at:

bash
Copy code
storage/framework/sessions
✦ Project Structure
text
Copy code
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
✦ Code Implementation
1) Session Controller
File: app/Http/Controllers/SessionController.php

php
Copy code
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
2) Routes
File: routes/web.php

php
Copy code
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;

Route::get('/session/set', [SessionController::class, 'storeSessionData']);
Route::get('/session/get', [SessionController::class, 'accessSessionData']);
Route::get('/session/remove', [SessionController::class, 'deleteSessionData']);
✦ API Endpoints
Method	Endpoint	Description
GET	/session/set	Store session data
GET	/session/get	Retrieve session data
GET	/session/remove	Delete session data

✦ Usage
Start the development server:

bash
Copy code
php artisan serve
Visit in browser:

text
Copy code
http://localhost:8000/session/set
http://localhost:8000/session/get
http://localhost:8000/session/remove
Flow:

swift
Copy code
/session/set → /session/get → /session/remove → /session/get
