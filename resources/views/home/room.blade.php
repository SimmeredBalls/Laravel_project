<div class="our_room">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="titlepage">
                    <h2>Our Room</h2>
                    <p>Explore our various room options to find the perfect stay.</p>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-4 col-sm-6">
                <div id="serv_hover" class="room">
                    <div class="room_img">
                        <figure><img style="height: 200px; width: 350px; padding-top: 15px;" src="images/room1.jpg" alt="#"/></figure>
                    </div>
                    <div class="bed_room">
                        <a class="book_btn" href="{{ route('our_room.details', ['type' => 'Regular']) }}">Regular</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div id="serv_hover" class="room">
                    <div class="room_img">
                        <figure><img style="height: 200px; width: 350px; padding-top: 15px;" src="images/room2.jpg" alt="#"/></figure>
                    </div>
                    <div class="bed_room">
                        <a class="book_btn" href="{{ route('our_room.details', ['type' => 'Premium']) }}">Premium</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div id="serv_hover" class="room">
                    <div class="room_img">
                        <figure><img style="height: 200px; width: 350px; padding-top: 15px;" src="images/room3.jpg" alt="#"/></figure>
                    </div>
                    <div class="bed_room">
                        <a class="book_btn" href="{{ route('our_room.details', ['type' => 'Deluxe']) }}">Deluxe</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>