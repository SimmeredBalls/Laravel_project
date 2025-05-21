<!DOCTYPE html>
<html>
  <head> 
    @include('admin.head')
    <style type="text/css">
        .table_deg
        {
            border: 2px solid white;
            margin: auto;
            width: 85%;
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
                <div  class="container-fluid">
                    
                <h2 style="text-align: center; padding: 20px;">Messages</h2>
                  <table class="table_deg">
                        <tr>
                            <th class="th_deg">Name</th>
                            <th class="th_deg">Email</th>
                            <th class="th_deg">Phone</th>
                            <th class="th_deg">Message</th>
                            <th class="th_deg">Send Email</th>
                        </tr>

                        @foreach($data as $data)
                        <tr>
                            <td>{{$data->name}}</td>
                            <td>{{$data->email}}</td>
                            <td>{{$data->phone}}</td>
                            <td>{{$data->message}}</td>
                            <td>
                              <a class="btn btn-success" href="{{url('send_mail', $data->id)}}">Send mail</a>
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