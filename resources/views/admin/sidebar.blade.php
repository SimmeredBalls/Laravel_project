<div class="d-flex align-items-stretch">
      <!-- Sidebar Navigation-->
      <nav id="sidebar">
        <!-- Sidebar Header-->
        <div class="sidebar-header d-flex align-items-center">
          <div class="avatar"><img src="admin/img/avatar-6.jpg" alt="..." class="img-fluid rounded-circle"></div>
          <div class="title">
            <h1 class="h5">Welcome Admin</h1>
            <p></p>
          </div>
        </div>
        <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
        <ul class="list-unstyled">
                <li class="{{ request()->is('home') ? 'active' : '' }}">
                  <a href="{{ url('home') }}"> <i class="icon-home"></i>Home</a>
                </li>
                <li><a href="#exampledropdownDropdown" aria-expanded="false" data-toggle="collapse"> <i class="icon-windows"></i>Hotel Rooms</a>
                  <ul id="exampledropdownDropdown" class="collapse list-unstyled ">
                    <li><a href="{{url('create_room')}}"> <i class="icon-page"></i>Add Rooms</a></li>
                    <li><a href="{{url('view_room')}}"> <i class="icon-page"></i>View Rooms</a></li>

                  </ul>
                </li>
              <li>
                  <a href="#staffDropdown" aria-expanded="false" data-toggle="collapse">
                      <i class="icon-user"></i>Manage Staff
                  </a>
                  <ul id="staffDropdown" class="collapse list-unstyled">
                      <li class="{{ request()->is('bookings') ? 'active' : '' }}"><a href="{{ route('admin.create_staff_form') }}">Add Staff</a></li>
                      <li><a href="{{ route('admin.view_staff') }}">View Staff</a></li>
                  </ul>
              </li>
                <li class="{{ request()->is('bookings') ? 'active' : '' }}">
                  <a href="{{url('bookings')}}"> <i class="icon-page"></i>Bookings</a>
              </li>  
              
              <li class="{{ request()->is('view_gallery') ? 'active' : '' }}">
                  <a href="{{url('view_gallery')}}"> <i class="icon-page"></i>Gallery</a>
              </li>

              <li class="{{ request()->is('all_messages') ? 'active' : '' }}">
                  <a href="{{url('all_messages')}}"> <i class="icon-page"></i>Messages</a>
              </li>

              <li class="{{ request()->is('payments') ? 'active' : '' }}">
                <a href="{{ route('admin.payments') }}"> <i class="icon-contract"></i>Payments</a>
              </li>


        </ul>
      </nav>