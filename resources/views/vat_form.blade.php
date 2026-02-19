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