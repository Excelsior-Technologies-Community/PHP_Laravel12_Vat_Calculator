# PHP_Laravel12_Vat_Calculator


## Project Description

PHP_Laravel12_Vat_Calculator is a Laravel 12 web application that calculates VAT (Value Added Tax) based on the net price and country code.

The application allows users to:

- Enter net price

- Enter country code

- Automatically calculate VAT rate

- Calculate VAT amount

- Calculate gross price (Net Price + VAT)

This project demonstrates how to build a simple VAT calculator using Laravel 12 with a clean UI and controller logic.


## Features

- Laravel 12 based project

- Simple VAT calculation logic

- Country-based VAT rates

- Clean Bootstrap UI

- Beginner-friendly structure

- No external API required

- Fast and reliable calculation


## Technologies Used

- Laravel 12

- PHP 8.2

- Bootstrap 5

- Blade Template

---



## Installation Steps


---


## STEP 1: Create Laravel 12 Project

### Open terminal / CMD and run:

```
composer create-project laravel/laravel PHP_Laravel12_Vat_Calculator "12.*"

```

### Go inside project:

```
cd PHP_Laravel12_Vat_Calculator

```

#### Explanation:

This command installs Laravel 12 and creates a new project folder with all required Laravel files and dependencies.

The cd command moves you into the project directory.



## STEP 2: Database Setup (Optional)

### Open .env and set:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel12_vat_calculator
DB_USERNAME=root
DB_PASSWORD=

```

### Create database in MySQL / phpMyAdmin:

```
Database name: laravel12_vat_calculator

```

#### Explanation:

This step connects your Laravel application to the MySQL database so Laravel can store and retrieve data.



## STEP 3: Install VAT Calculator Package

### Run:

```
composer require mpociot/vat-calculator

```

#### Explanation:

This command installs the VAT Calculator package using Composer.

This package helps calculate VAT, but in this project VAT is calculated manually in the controller.





## STEP 4: Create Controller

### Run:

```
php artisan make:controller VatController

```


### app/Http/Controllers/VatController.php

```
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VatController extends Controller
{
    // Fixed VAT rates for countries
    protected $vatRates = [
        'DE' => 19,  // Germany
        'FR' => 20,  // France
        'IT' => 22,  // Italy
        'ES' => 21,  // Spain
        'UK' => 20,  // United Kingdom
    ];

    // Show the form
    public function index()
    {
        return view('vat_form');
    }

    // Calculate VAT
    public function calculate(Request $request)
    {
        $netPrice = $request->net_price;
        $countryCode = strtoupper($request->country_code);

        $taxRate = $this->vatRates[$countryCode] ?? 0; // default 0 if country not found
        $taxValue = $netPrice * ($taxRate / 100);
        $grossPrice = $netPrice + $taxValue;

        return view('vat_form', compact(
            'netPrice',
            'grossPrice',
            'taxRate',
            'taxValue',
            'countryCode'
        ));
    }
}

```

#### Explanation:

This controller receives user input, calculates VAT amount, and returns the result to the view.




## STEP 5: Create View File

### Go to:

```
resources
→ views

```

### Create new file: resource/views/vat_form.blade.php

```
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laravel 12 VAT Calculator</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
        }

        .vat-card {
            background: #fff;
            border-radius: 15px;
            padding: 30px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .vat-title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
            color: #0d6efd;
        }

        .btn-custom {
            width: 100%;
            font-weight: bold;
            padding: 10px;
            border-radius: 10px;
        }

        .result-box {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-top: 20px;
        }

        .result-box p {
            margin: 5px 0;
            font-weight: 500;
        }
    </style>

</head>

<body>

    <div class="vat-card">

        <h2 class="vat-title">VAT Calculator</h2>

        <form method="POST" action="{{ route('vat.calculate') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Net Price</label>
                <input type="number" step="0.01" name="net_price" class="form-control" value="{{ $netPrice ?? '' }}"
                    placeholder="Enter net price" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Country Code</label>
                <input type="text" name="country_code" class="form-control" value="{{ $countryCode ?? '' }}"
                    placeholder="Example: DE, FR, IT" required>
            </div>

            <button type="submit" class="btn btn-primary btn-custom">
                Calculate VAT
            </button>

        </form>

        @if(isset($grossPrice))
            <div class="result-box">
                <h5 class="text-success text-center mb-3">Calculation Result</h5>

                <p>Net Price: <span class="float-end">{{ $netPrice }}</span></p>

                <p>Country Code: <span class="float-end">{{ $countryCode }}</span></p>

                <p>VAT Rate:
                    <span class="float-end">{{ $taxRate }}%</span>
                </p>

                <p>VAT Amount:
                    <span class="float-end text-danger">{{ number_format($taxValue, 2) }}</span>
                </p>

                <hr>

                <p class="fw-bold">
                    Gross Price:
                    <span class="float-end text-primary">
                        {{ number_format($grossPrice, 2) }}
                    </span>
                </p>
            </div>
        @endif

    </div>

</body>

</html>

```

#### Explanation:

This file contains the form where the user enters net price and country code and displays the VAT result using Bootstrap UI.




## STEP 6: Add Route

### Open: routes/web.php

Replace with:

```
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VatController;

Route::get('/', [VatController::class, 'index']);

Route::post('/calculate', [VatController::class, 'calculate'])
    ->name('vat.calculate');

```

#### Explanation:

Routes connect the browser URL with the controller methods.

GET route shows the form and POST route calculates VAT.




## STEP 7: Launch the Server

### Run:

```
php artisan serve

```
### Then open your browser:

```
http://127.0.0.1:8000

```


#### Explanation:

This command starts the Laravel development server so you can run the application in your browser.




## Application Output


### The user enters Net Price and Country Code.

#### DE Code:


<img width="1919" height="956" alt="Screenshot 2026-02-19 114216" src="https://github.com/user-attachments/assets/7f800651-3e6f-4298-8f0b-6f39375d3a95" />

<img width="1919" height="970" alt="Screenshot 2026-02-19 112329" src="https://github.com/user-attachments/assets/a1beda03-5c4a-4a6b-8bab-b4e3f9c1267d" />


#### FR Code:

<img width="1919" height="951" alt="Screenshot 2026-02-19 114250" src="https://github.com/user-attachments/assets/4157fcc2-20e2-4049-983f-1bcdde5b216c" />

<img width="1916" height="957" alt="Screenshot 2026-02-19 114300" src="https://github.com/user-attachments/assets/839d349f-2be8-4938-b7a8-1e8e4710e4a6" />


---

# Project Folder Structure:

```
PHP_Laravel12_Vat_Calculator
│
├── app
│   └── Http
│       └── Controllers
│           └── VatController.php
│
├── resources
│   └── views
│       └── vat_form.blade.php
│
├── routes
│   └── web.php
│
├── config
│   └── app.php
│
├── .env
│
└── README.md

```

