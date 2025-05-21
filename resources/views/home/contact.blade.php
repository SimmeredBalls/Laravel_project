<div class="contact">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage">
                     <h2>Contact Us</h2>
                  </div>

                  @if(session()->has('message'))
                     <div class="alert alert-success">
                        <button type="button" class="close" data-bs-dismiss='alert'>X</button>
                        {{session()->get('message')}}
                     </div>
                  @endif
               </div>
            </div>
            <div class="row justify-content-center">
               <div class="col-md-6 text-center">
                  <form id="request" class="main_form" action="{{url('contact')}}" method="Post">
                     @csrf
                     <div class="row">
                        <div class="col-md-12 ">
                           <input class="contactus" placeholder="Name" type="type" name="name" required> 
                        </div>
                        <div class="col-md-12">
                           <input class="contactus" placeholder="Email" type="email" name="email" required> 
                        </div>
                        <div class="col-md-12">
                           <input class="contactus" placeholder="Phone Number" type="number" name="phone" required>                          
                        </div>
                        <div class="col-md-12">
                           <textarea class="textarea" placeholder="Message" type="type" name="message" required></textarea>
                        </div>
                        <div class="col-md-12">
                           <button type="submit" class="send_btn">Send</button>
                        </div>
                     </div>
                  </form>
               </div>
              
            </div>
         </div>
      </div>