<!DOCTYPE html>
<html>
<head> 
    @include('admin.head')
    <style type="text/css">
        label {
            display: inline-block;
            width: 200px;
        }

        .div_deg {
            padding-top: 30px;
        }

        .div_center {
            text-align: center;
            padding-top: 40px;
        }
    </style>
</head>
<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">

                <div class="div_center">
                    <h1 style="font-size: 30px; font-weight: bold;">Create Staff Profile</h1>

                    @if(session('success'))
                        <div class="alert alert-success" style="margin-bottom: 20px;">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger" style="margin-bottom: 20px;">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.create_staff') }}" method="POST">
                        @csrf

                        <div class="div_deg">
                            <label>Name</label>
                            <input type="text" name="name" required>
                        </div>

                        <div class="div_deg">
                            <label>Email</label>
                            <input type="email" name="email" required>
                        </div>

                        <div class="div_deg">
                            <label>Phone (optional)</label>
                            <input type="text" name="phone">
                        </div>

                        <div class="div_deg">
                            <label>Job Role</label>
                            <input type="text" name="role" placeholder="e.g. receptionist, cook" required>
                        </div>

                        <div class="div_deg">
                            <input class="btn btn-primary" type="submit" value="Create Staff">
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    @include('admin.footer')
</body>
</html>
