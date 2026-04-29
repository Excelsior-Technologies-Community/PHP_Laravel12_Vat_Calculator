<!DOCTYPE html>
<html>
<head>
    <title>VAT History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background:#f4f6f9;padding:30px;">

<div class="container">

    <h2 class="mb-4 text-center">VAT Calculation History</h2>

    <a href="/" class="btn btn-primary mb-3">Back</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Net Price</th>
                <th>Country</th>
                <th>VAT %</th>
                <th>VAT Amount</th>
                <th>Gross Price</th>
            </tr>
        </thead>

        <tbody>
            @foreach($data as $row)
                <tr>
                    <td>{{ $row->id }}</td>
                    <td>{{ $row->net_price }}</td>
                    <td>{{ $row->country_code }}</td>
                    <td>{{ $row->vat_rate }}%</td>
                    <td>{{ number_format($row->vat_amount, 2) }}</td>
                    <td>{{ number_format($row->gross_price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>

    </table>

</div>

</body>
</html>