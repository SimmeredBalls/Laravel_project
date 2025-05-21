<!DOCTYPE html>
<html lang="en">
   <head>
      @include('home.head')
      <style>
         .booking-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 20px;
         }
         .booking-card p {
            margin: 4px 0;
         }
         .cancel-btn {
            background-color: #e3342f;
            color: #fff;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            margin-top: 10px;
            cursor: pointer;
         }
         .cancel-btn:hover {
            background-color: #cc1f1a;
         }
         .status-approved {
            color: green;
            font-weight: bold;
         }
         .status-rejected {
            color: red;
            font-weight: bold;
         }
         .status-pending {
            color: orange;
            font-weight: bold;
         }
      </style>
   </head>
   <body class="main-layout">
      <!-- loader  -->
      <div class="loader_bg">
         <div class="loader"><img src="images/loading.gif" alt="#"/></div>
      </div>
      <!-- end loader -->

      <!-- header -->
      @include('home.header')
      <!-- end header -->

      <!-- main content -->
      <div class="container mt-5 mb-5" style="max-width: 900px;">
         <h1 class="text-2xl font-bold mb-4">My Bookings</h1>

         @if(session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('status') }}
            </div>
         @endif

         @forelse($bookings as $booking)
            <div class="booking-card">
                  <p><strong>Room:</strong> {{ $booking->room->room_title ?? 'Room Deleted' }}</p>
                  <p><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($booking->start_date)->format('M d, Y') }}</p>
                  <p><strong>End Date:</strong> {{ \Carbon\Carbon::parse($booking->end_date)->format('M d, Y') }}</p>
                  <p><strong>Nights:</strong> {{ $booking->nights }}</p>
                  <p><strong>Status:</strong>
                     <span class="status-{{ $booking->status ?? 'pending' }}">
                        {{ ucfirst($booking->status ?? 'pending') }}
                     </span>
                  </p>
                  <p><strong>Payment Method:</strong>
                     {{ $booking->payment->payment_method ?? 'Not Selected' }}
                  </p>

                  <p><strong>Payment Status:</strong>
                     @if($booking->payment)
                        <span class="text-{{ $booking->payment->status === 'completed' ? 'success' : 'warning' }}">
                           {{ ucfirst($booking->payment->status) }}
                        </span>
                     @else
                        <span class="text-danger">No Payment Recorded</span>
                     @endif
                  </p>

                  <p><strong>Total Price:</strong>
                     ₱{{ number_format($booking->total_price, 2) }}
                     @if(optional($booking->payment)->status === 'completed')
                        <span class="text-success">(Paid)</span>
                     @elseif(optional($booking->payment)->payment_method === 'cash')
                        <span class="text-warning">(To Pay on Arrival)</span>
                     @else
                        <span class="text-danger">(Unpaid)</span>
                     @endif
                  </p>

                  @if($booking->payment && $booking->payment->status === 'completed' && $booking->invoice)
                     <p><strong>Invoice:</strong>
                        <a href="{{ route('invoice.show', $booking->invoice->id) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                           View Invoice
                        </a>
                     </p>
                  @endif


               <form action="{{ route('cancel.booking', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="cancel-btn">Cancel Booking</button>
               </form>
            </div>
         @empty
            <p class="text-gray-600">You have no bookings yet.</p>
         @endforelse
      </div>
      <!-- end main content -->

      @include('home.footer')
   </body>
</html>
