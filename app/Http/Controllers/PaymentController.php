<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Booking;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function store(Request $request, $bookingId)
    {
        $request->validate([
            'payment_method' => 'required|in:credit_card,paypal,cash',
        ]);

        $booking = Booking::where('id', $bookingId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Prevent double payment
        if ($booking->payment) {
            return redirect()->route('my.bookings')->with('status', 'Payment already recorded.');
        }

        // Default status and fields
        $isCash = $request->payment_method === 'cash';

        $payment = Payment::create([
            'user_id'        => Auth::id(),
            'booking_id'     => $booking->id,
            'amount'         => $booking->total_price,
            'payment_method' => $request->payment_method,
            'status'         => $isCash ? 'pending' : 'completed',
            'paid_at'        => $isCash ? null : now(),
            'transaction_id' => $isCash ? null : strtoupper(Str::uuid()),
        ]);

        // Create invoice ONLY if payment is completed (online)
        if (!$isCash) {
            Invoice::create([
                'booking_id'     => $booking->id,
                'invoice_number' => 'INV-' . strtoupper(Str::random(8)),
                'total_amount'   => $booking->total_price,
                'issued_at'      => now(),
            ]);
        }

        return redirect()->route('my.bookings')->with('status', $isCash 
            ? 'Payment will be completed upon arrival.'
            : 'Payment successful and invoice generated.'
        );
    }

    public function showPaymentForm($bookingId)
    {
        $booking = Booking::with('room')->where('id', $bookingId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('home.payment_form', compact('booking'));
    }

}
