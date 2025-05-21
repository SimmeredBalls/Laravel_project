<!DOCTYPE html>
<html>
  <head> 
    @include('admin.head')
    <style type="text/css">
        .table_deg
        {
            border: 2px solid white;
            margin: auto;
            width: 100%;
            text-align: center;
            margin-top: 40px;
        }

        .th_deg
        {
            background-color: #ab4b52;
            padding: 8px;
            color: white;
        }

        tr
        {
            border: 2px solid grey;
        }

        td
        {
            padding: 10px;
        }
    </style>
  </head>
  <body>
        @include('admin.header')
        @include('admin.sidebar')
        <!-- Sidebar Navigation end-->
        <div class="page-content">
            <div class="page-header">
                <div class="container-fluid">
                    <h2 style="text-align: center; padding: 20px;">Bookings</h2>
                    <table class="table_deg">
                        <tr>
                            <th class="th_deg">Room ID</th>
                            <th class="th_deg">Customer Name</th>
                            <th class="th_deg">Email</th>
                            <th class="th_deg">Phone</th>
                            <th class="th_deg">Arrival Date</th>
                            <th class="th_deg">Leaving Date</th>
                            <th class="th_deg">Nights</th>
                            <th class="th_deg">Room Title</th>
                            <th class="th_deg">Room Price</th>
                            <th class="th_deg">Total Price</th>
                            <th class="th_deg">Status</th>
                            <th class="th_deg">Image</th>
                            <th class="th_deg">Delete</th>
                            <th class="th_deg">Status Update</th>
                        </tr>

                        @foreach($data as $data)
                            <tr>
                                <td>{{ $data->room_id }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->email }}</td>
                                <td>{{ $data->phone }}</td>
                                <td>{{ $data->start_date }}</td>
                                <td>{{ $data->end_date }}</td>
                                <td>{{ $data->nights }}</td>
                                <td>{{ $data->room->room_title ?? 'N/A' }}</td>
                                <td>₱{{ number_format($data->room->price, 2) }}</td>
                                <td>₱{{ number_format($data->total_price, 2) }}</td>

                                <td>
                                    @if($data->status == 'approve')
                                        <span style="color:green;">Approved</span>
                                    @elseif($data->status == 'rejected')
                                        <span style="color:red;">Rejected</span>
                                    @elseif($data->status == 'waiting')
                                        <span style="color:yellow;">Waiting</span>
                                    @elseif($data->status == 'cancelled')
                                        <span style="color:red;">Cancelled</span>
                                    @endif
                                </td>

                                <td>
                                    <img src="/room/{{ $data->room->image }}" style="width: 120px; height: auto; border-radius: 6px; box-shadow: 0 0 6px rgba(0,0,0,0.2);">
                                </td>

                                <td>
                                    <a onclick="return confirm('Are you sure to delete this?');" class="btn btn-danger" href="{{ url('delete_booking', $data->id) }}">Delete</a>
                                </td>

                                <td>
                                    <div class="d-flex flex-column align-items-center">
                                        <a class="btn btn-success mb-2" href="{{ url('approve_book', $data->id) }}">Approve</a>
                                        <a class="btn btn-warning" href="{{ url('reject_book', $data->id) }}">Reject</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>

        </div>
            </div>
                </div>        
        @include('admin.footer')
  </body>
</html>