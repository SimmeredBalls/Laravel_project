<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/public">
    @include('home.head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</head>
<body class="main-layout">
    <div class="loader_bg">
        <div class="loader"><img src="images/loading.gif" alt="#"/></div>
    </div>
    @include('home.header')
    <div class="our_room">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage">
                        <h2>Our Rooms</h2>
                        <p>Explore our available rooms and filter based on your preferences.</p>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-12">
                    <form action="{{ route('our_room.details') }}" method="GET">
                        <div class="form-row align-items-center">
                            <div class="col-auto mb-2">
                                <label class="sr-only" for="type">Room Type</label>
                                <select class="form-control" id="type" name="type">
                                    <option value="">All Types</option>
                                    <option value="Regular" {{ request('type') === 'Regular' ? 'selected' : '' }}>Regular</option>
                                    <option value="Premium" {{ request('type') === 'Premium' ? 'selected' : '' }}>Premium</option>
                                    <option value="Deluxe" {{ request('type') === 'Deluxe' ? 'selected' : '' }}>Deluxe</option>
                                </select>
                            </div>
                            <div class="col-auto mb-2">
                                <label class="sr-only" for="room_title">Name</label>
                                <input type="text" class="form-control" id="room_title" name="room_title" placeholder="Room Name" value="{{ request('room_title') }}">
                            </div>
                            <div class="col-auto mb-2">
                                <label class="sr-only" for="price_min">Min Price</label>
                                <input type="number" class="form-control" id="price_min" name="price_min" placeholder="Min Price" value="{{ request('price_min') }}">
                            </div>
                            <div class="col-auto mb-2">
                                <label class="sr-only" for="price_max">Max Price</label>
                                <input type="number" class="form-control" id="price_max" name="price_max" placeholder="Max Price" value="{{ request('price_max') }}">
                            </div>
                            <div class="col-auto mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="wifi" name="wifi" {{ request('wifi') === 'on' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="wifi">
                                        Wi-Fi
                                    </label>
                                </div>
                            </div>
                            <div class="col-auto mb-2">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="{{ route('our_room.details') }}" class="btn btn-secondary ml-2">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                @forelse($room as $rooms)
                <div class="col-md-4 col-sm-6 mb-4">
                    <div id="serv_hover" class="room">
                        <div class="room_img">
                            <figure><img style="height: 200px; width: 350px; padding: 10px;" src="{{ asset('room/' . $rooms->image) }}" alt="{{ $rooms->room_title }}"/></figure>
                        </div>
                        <div class="bed_room">
                            <h3>{{ $rooms->room_title }}</h3>
                            <p style="padding:10px">{!! Str::limit($rooms->description, 100) !!}</p>
                            <h4>Price: ₱{{ $rooms->price }}</h4>
                            <h5>Type: {{ $rooms->room_type }}</h5>
                            <h5>Wifi: {{ $rooms->wifi }}</h5>
                            <a class="btn btn-primary" href="{{ url('room_details', $rooms->id) }}">Room Details</a>
                        </div>
                    </div>
                </div>
                @empty
                    <div class="col-md-12">
                        <p>No rooms found matching your criteria.</p>
                    </div>
                @endforelse
            </div>

            <div class="row">
                <div class="col-md-12">
                    {{ $room->links() }} {{-- Display pagination links --}}
                </div>
            </div>
        </div>
    </div>
    @include('home.footer')
</body>
</html>