<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laravel 12 VAT Calculator</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

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

        <!-- VALIDATION ERRORS -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('vat.calculate') }}">
            @csrf

            <!-- Net Price -->
            <div class="mb-3">
                <label class="form-label">Net Price</label>
                <input type="number" step="0.01" name="net_price" class="form-control"
                    value="{{ old('net_price', $netPrice ?? '') }}"
                    placeholder="Enter net price" required>
            </div>

            <!-- COUNTRY DROPDOWN -->
            <div class="mb-3">
                <label class="form-label">Country</label>
                <select name="country_code" class="form-control" required>
                    <option value="">Select Country</option>
                    <option value="IN" {{ (old('country_code', $countryCode ?? '') == 'IN') ? 'selected' : '' }}>India</option>
                    <option value="DE" {{ (old('country_code', $countryCode ?? '') == 'DE') ? 'selected' : '' }}>Germany</option>
                    <option value="FR" {{ (old('country_code', $countryCode ?? '') == 'FR') ? 'selected' : '' }}>France</option>
                    <option value="IT" {{ (old('country_code', $countryCode ?? '') == 'IT') ? 'selected' : '' }}>Italy</option>
                    <option value="ES" {{ (old('country_code', $countryCode ?? '') == 'ES') ? 'selected' : '' }}>Spain</option>
                    <option value="UK" {{ (old('country_code', $countryCode ?? '') == 'UK') ? 'selected' : '' }}>United Kingdom</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary btn-custom">
                Calculate VAT
            </button>

        </form>

        <!-- HISTORY BUTTON -->
        <a href="{{ route('vat.history') }}" class="btn btn-dark btn-custom mt-2">
            View History
        </a>

        <!-- RESULT -->
        @if(isset($grossPrice))
            <div class="result-box">
                <h5 class="text-success text-center mb-3">Calculation Result</h5>

                <p>Net Price: <span class="float-end">{{ $netPrice }}</span></p>

                <p>Country: <span class="float-end">{{ $countryCode }}</span></p>

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