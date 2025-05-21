<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function show($id)
    {
        $invoice = Invoice::with('booking.room')->findOrFail($id);

        if (Auth::id() !== $invoice->booking->user_id) {
            abort(403, 'Unauthorized');
        }

        return view('invoice.show', compact('invoice'));
    }
}
