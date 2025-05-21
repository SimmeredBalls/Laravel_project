<!DOCTYPE html>
<html lang="en">
   <head>
      <base href="/public">
      @include('home.head')

      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

      <style type="text/css">
         label {
            display: inline-block;
            width: 200px;
         }
         input, textarea {
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
                     <h2>Our Room</h2>
                  </div>
               </div>
            </div>

            <div class="row">
               <div class="col-md-8">
                  <div id="serv_hover" class="room">
                     <div style="padding:20px" class="room_img">
                        <img style="height: 300px; width: 750px; padding-top: 25px;" src="/room/{{$room->image}}" alt="Room Image"/>
                     </div>
                     <div class="bed_room">
                        <h2>{{$room->room_title}}</h2>
                        <p style="padding: 12px">{{$room->description}}</p>
                        <h4 style="padding: 12px">Free wifi: {{$room->wifi}}</h4>
                        <h4 style="padding: 12px">Room Type: {{$room->room_type}}</h4>
                        <h3 style="padding: 12px">Price per night: ₱{{ $room->price }}</h3>
                     </div>
                  </div>
               </div>

               <div class="col-md-4">
                  <h1 style="font-size: 40px!important;">Book Room</h1>

                  @if(session()->has('message') && session()->get('message') == '0') 
                     <div class="alert alert-danger">
                        <button type="button" class="close" data-bs-dismiss="alert">X</button>
                        Room is already booked. Please try a different date.
                     </div>
                  @elseif(session()->has('message') && session()->get('message') == '1')
                     <div class="alert alert-success">
                        <button type="button" class="close" data-bs-dismiss="alert">X</button>
                        Room Booked Successfully.
                     </div>

                     <div class="alert alert-info mt-3">
                     <h5 class="mb-3">Choose Payment Option</h5>
                     <form method="POST" action="{{ route('payment.store', $room->id) }}">
                        @csrf
                        <div class="mb-3">
                           <label for="payment_method" class="form-label">Payment Method</label>
                           <select name="payment_method" id="payment_method" class="form-control" required>
                                 <option value="">-- Select --</option>
                                 <option value="credit_card">Credit Card</option>
                                 <option value="paypal">PayPal</option>
                                 <option value="cash">Pay on Arrival</option>
                           </select>
                        </div>
                        <button type="submit" class="btn btn-success">Confirm Payment Option</button>
                     </form>

                     </div>
                  @endif

                  @if($errors)
                     @foreach($errors->all() as $error)
                        <li style="color:red">{{ $error }}</li>
                     @endforeach
                  @endif

                  @auth
                     <div class="mb-4">
                        <label class="fw-bold text-danger mb-2">Unavailable Dates:</label>
                        <ul class="list-group">
                           @forelse($bookings as $booking)
                              <li class="list-group-item list-group-item-warning d-flex justify-content-between align-items-center">
                                 Occupied from 
                                 <span class="fw-semibold">
                                    {{ \Carbon\Carbon::parse($booking->start_date)->format('M d, Y') }}
                                    &rarr;
                                    {{ \Carbon\Carbon::parse($booking->end_date)->format('M d, Y') }}
                                 </span>
                              </li>
                           @empty
                              <li class="list-group-item list-group-item-success">
                                 This room is currently <strong>available</strong> for all dates.
                              </li>
                           @endforelse
                        </ul>
                     </div>

                     <form action="{{ url('add_booking', $room->id) }}" method="POST">
                        @csrf
                        <div style="padding-bottom: 10px;">
                           <label>Name</label>
                           <input type="text" name="name" value="{{ Auth::user()->name }}">
                        </div>

                        <div style="padding-bottom: 10px;">
                           <label>Email</label>
                           <input type="email" name="email" value="{{ Auth::user()->email }}">
                        </div>

                        <div style="padding-bottom: 10px;">
                           <label>Phone</label>
                           <input type="text" name="phone" value="{{ old('phone', Auth::user()->phone ?? '') }}">
                        </div>

                        <div style="padding-bottom: 10px;">
                           <label>Start Date</label>
                           <input type="date" name="startDate" id="startDate">
                        </div>

                        <div style="padding-bottom: 10px;">
                           <label>End Date</label>
                           <input type="date" name="endDate" id="endDate">
                        </div>

                        <div style="padding-bottom: 10px;">
                           <label>Notes (optional)</label>
                           <textarea name="notes" class="form-control"></textarea>
                        </div>

                        <div style="padding-bottom: 10px;">
                           <strong id="totalPriceDisplay" class="text-info">Total Price: ₱{{ $room->price }}</strong>
                           <input type="hidden" name="total_price" id="total_price" value="{{ $room->price }}">
                        </div>

                        <div style="padding-top: 20px;">
                           <input type="submit" class="btn btn-primary" value="Book Room">
                        </div>
                     </form>
                  @endauth

                  @guest
                     <div class="alert alert-warning mt-3">
                        Please <a href="{{ route('login') }}">login</a> to book this room.
                     </div>
                  @endguest
               </div>
            </div>
         </div>
      </div>

      @include('home.footer')

      <script type="text/javascript">
         $(function() {
            var dtToday = new Date();
            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate();
            var year = dtToday.getFullYear();

            if(month < 10) month = '0' + month.toString();
            if(day < 10) day = '0' + day.toString();

            var minDate = year + '-' + month + '-' + day;
            $('#startDate').attr('min', minDate);
            $('#endDate').attr('min', minDate);
         });

         // Price calculation
         const startDateInput = document.getElementById('startDate');
         const endDateInput = document.getElementById('endDate');
         const totalDisplay = document.getElementById('totalPriceDisplay');
         const totalHidden = document.getElementById('total_price');
         const nightlyRate = {{ $room->price }};

         function updateTotal() {
            const start = new Date(startDateInput.value);
            const end = new Date(endDateInput.value);
            const msPerDay = 1000 * 60 * 60 * 24;
            const diffDays = Math.max(Math.round((end - start) / msPerDay), 1);
            const total = nightlyRate * diffDays;

            if (!isNaN(total)) {
               totalDisplay.innerText = `Total Price: ₱${total.toFixed(2)} for ${diffDays} night(s)`;
               totalHidden.value = total;
            }
         }

         startDateInput.addEventListener('change', updateTotal);
         endDateInput.addEventListener('change', updateTotal);
      </script>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
   </body>
</html>
