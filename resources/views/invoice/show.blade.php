<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            margin: 40px;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        }
        h2 {
            margin-bottom: 0;
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .invoice-details, .room-details {
            margin-top: 30px;
        }
        .invoice-details table, .room-details table {
            width: 100%;
            border-collapse: collapse;
        }
        .invoice-details td, .room-details td {
            padding: 8px;
            border-bottom: 1px solid #eee;
        }
        .total {
            font-weight: bold;
            font-size: 18px;
        }
        .footer {
            margin-top: 40px;
            font-size: 14px;
            color: #888;
        }
    </style>
</head>
<body>
<div class="invoice-box">
    <div class="invoice-header">
        <h2>Invoice</h2>
        <div>
            <strong>Invoice #:</strong> {{ $invoice->invoice_number }}<br>
            <strong>Issued:</strong> {{ \Carbon\Carbon::parse($invoice->issued_at)->format('M d, Y') }}
        </div>
    </div>

    <div class="invoice-details">
        <h4>Customer Information</h4>
        <table>
            <tr>
                <td><strong>Name:</strong> {{ $invoice->booking->name }}</td>
                <td><strong>Email:</strong> {{ $invoice->booking->email }}</td>
            </tr>
            <tr>
                <td><strong>Phone:</strong> {{ $invoice->booking->phone }}</td>
                <td><strong>Status:</strong> {{ ucfirst($invoice->booking->status) }}</td>
            </tr>
        </table>
    </div>

    <div class="room-details">
        <h4>Room Booking Details</h4>
        <table>
            <tr>
                <td><strong>Room:</strong> {{ $invoice->booking->room->room_title ?? 'Room Deleted' }}</td>
                <td><strong>Type:</strong> {{ $invoice->booking->room->room_type ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>Check-in:</strong> {{ $invoice->booking->start_date }}</td>
                <td><strong>Check-out:</strong> {{ $invoice->booking->end_date }}</td>
            </tr>
            <tr>
                <td><strong>Nights:</strong> {{ $invoice->booking->nights }}</td>
                <td class="total"><strong>Total Paid:</strong> ₱{{ number_format($invoice->total_amount, 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Thank you for booking with us.<br>
        This invoice was generated automatically.
    </div>
</div>
</body>
</html>
