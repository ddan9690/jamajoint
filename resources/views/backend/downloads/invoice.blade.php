<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <style>
        /* CSS styles for the invoice */
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        .invoice-header {
            text-align: center;
        }

        .logo {
            max-width: 150px;
        }

        .invoice-title {
            font-size: 24px;
            margin-top: 20px;
        }

        .invoice-details {
            margin-top: 20px;
        }

        .invoice-details p {
            margin: 0;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .invoice-table th,
        .invoice-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .invoice-table th {
            background-color: #f2f2f2;
        }

        .invoice-total {
            margin-top: 20px;
        }

        .invoice-header a {
        text-decoration: none;
        color: #333;
    }
    </style>
</head>
<body>
    <div class="container">
        <div class="invoice-header">
            <img src="{{ public_path('backend/img/logo/cyberspace-national-joint-logo.png') }}" alt="Logo" class="logo">
            <p><strong></strong> <a href="http://www.cyberspace.co.ke" target="_blank">www.cyberspace.co.ke</a></p>
            <h1 class="invoice-title">Invoice</h1>
        </div>

        <div class="invoice-details">
            <p><strong>Invoice No:</strong> {{ $invoice->invoice_number }}</p>
            <p><strong>Date:</strong> {{ $invoice->created_at->format('d-m-Y') }}</p>
            <p><strong>School:</strong> {{ $invoice->school->name }}</p>
        </div>

        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Subscription for {{ $invoice->exam->name }} Term {{ $invoice->exam->term }} -{{ $invoice->exam->year }}</td>
                </tr>
            </tbody>
        </table>

        <div class="invoice-total">
            <p><strong>Total Amount:</strong> Ksh {{ number_format($invoice->amount, 2) }}</p>
        </div>
    </div>
</body>
</html>
