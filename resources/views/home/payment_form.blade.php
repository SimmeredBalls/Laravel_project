<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/public">
    @include('home.head')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <style>
        label {
            display: inline-block;
            width: 200px;
        }
        input, select {
            width: 100%;
        }
    </style>
</head>
<body class="main-layout">
    <!-- loader -->
    <div class="loader_bg">
        <div class="loader"><img src="images/loading.gif" alt="#"/></div>
    </div>

    <!-- header -->
    @include('home.header')

    <div class="our_room">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage">
                        <h2>Payment</h2>
                        <p>Please select your preferred payment method below</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div id="serv_hover" class="room">
                        <div style="padding:20px" class="room_img">
                            <img style="height: 300px; width: 750px; padding-top: 25px;" src="/room/{{ $booking->room->image }}" alt="Room Image"/>
                        </div>
                        <div class="bed_room">
                            <h2>{{ $booking->room->room_title }}</h2>
                            <p style="padding: 12px">Check-in: {{ \Carbon\Carbon::parse($booking->start_date)->format('F j, Y') }}</p>
                            <p style="padding: 12px">Check-out: {{ \Carbon\Carbon::parse($booking->end_date)->format('F j, Y') }}</p>
                            <p style="padding: 12px">Nights: {{ $booking->nights }}</p>
                            <h3 style="padding: 12px">Total: ₱{{ number_format($booking->total_price, 2) }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <h1 style="font-size: 30px!important;">Confirm Payment</h1>

                    <form method="POST" action="{{ route('payment.store', $booking->id) }}">
                        @csrf

                        <div class="mb-3">
                            <label for="payment_method">Select Payment Method</label>
                            <select name="payment_method" id="payment_method" class="form-control" required>
                                <option value="">-- Choose --</option>
                                <option value="credit_card">Credit Card</option>
                                <option value="paypal">PayPal</option>
                                <option value="cash">Pay on Arrival</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Confirm Payment</button>
                    </form>

                    @if ($errors->any())
                        <div class="alert alert-danger mt-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    @include('home.footer')
</body>
</html>