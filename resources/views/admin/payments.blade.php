<!DOCTYPE html>
<html>
  <head> 
    @include('admin.head')
    <style type="text/css">
        .table_deg {
            border: 2px solid grey;
            margin: auto;
            width: 90%;
            text-align: center;
            margin-top: 40px;
        }

        .th_deg {
            background-color: #ab4b52;
            padding: 10px;
            color: white;
        }

        td {
            padding: 10px;
        }

        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
        }

        .badge-success { background-color: green; color: white; }
        .badge-warning { background-color: orange; color: white; }
        .badge-danger { background-color: red; color: white; }
    </style>
  </head>
  <body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
      <div class="page-header">
        <div class="container-fluid">
          <h2 class="text-center" style="padding: 20px;">Payment Transactions</h2>
          <table class="table_deg">
            <tr>
              <th class="th_deg">ID</th>
              <th class="th_deg">User</th>
              <th class="th_deg">Email</th>
              <th class="th_deg">Booking ID</th>
              <th class="th_deg">Room</th>
              <th class="th_deg">Total Paid</th> <!-- Changed from 'Amount' -->
              <th class="th_deg">Method</th>
              <th class="th_deg">Status</th>
              <th class="th_deg">Paid At</th>
            </tr>

            @forelse($payments as $payment)
              <tr>
                <td>{{ $payment->id }}</td>
                <td>{{ $payment->user->name ?? 'N/A' }}</td>
                <td>{{ $payment->user->email ?? 'N/A' }}</td>
                <td>{{ $payment->booking_id }}</td>
                <td>{{ $payment->booking->room->room_title ?? 'Room Deleted' }}</td>
                <td>₱{{ number_format($payment->amount, 2) }}</td> <!-- Corrected -->
                <td>{{ ucfirst($payment->payment_method) }}</td>
                <td>
                  @if($payment->status == 'completed')
                    <span class="badge badge-success">Completed</span>
                  @elseif($payment->status == 'pending' && $payment->payment_method == 'cash')
                    <span class="badge badge-warning">Pending</span><br>
                    <form action="{{ route('admin.mark_paid', $payment->id) }}" method="POST" onsubmit="return confirm('Mark this payment as completed?')">
                      @csrf
                      <button type="submit" class="btn btn-sm btn-success mt-2">Mark as Paid</button>
                    </form>
                  @elseif($payment->status == 'pending')
                    <span class="badge badge-warning">Pending</span>
                  @else
                    <span class="badge badge-danger">Failed</span>
                  @endif
                </td>
                <td>
                  {{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('M d, Y h:i A') : 'N/A' }}
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="9">No payments found.</td>
              </tr>
            @endforelse
          </table>
        </div>
      </div>
    </div>

    @include('admin.footer')
  </body>
</html>
