<!DOCTYPE html>
<html>
<head>
    @include('admin.head')
    <style>
        .table_deg {
            border: 2px solid white;
            margin: auto;
            width: 100%;
            text-align: center;
            margin-top: 40px;
        }

        .th_deg {
            background-color: #ab4b52;
            padding: 8px;
            color: white;
        }

        td {
            padding: 10px;
        }
    </style>
</head>
<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">

                @if(session('success'))
                    <div class="alert alert-success text-center">{{ session('success') }}</div>
                @endif

                <table class="table_deg">
                    <tr>
                        <th class="th_deg">Name</th>
                        <th class="th_deg">Email</th>
                        <th class="th_deg">Phone</th>
                        <th class="th_deg">Job Role</th>
                        <th class="th_deg">Delete</th>
                        <th class="th_deg">Update</th>
                    </tr>

                    @foreach($staff as $member)
                    <tr>
                        <td>{{ $member->name }}</td>
                        <td>{{ $member->email }}</td>
                        <td>{{ $member->phone }}</td>
                        <td>{{ ucfirst($member->role) }}</td>

                        <td>
                            <a onclick="return confirm('Are you sure to delete this?');"
                               class="btn btn-danger"
                               href="{{ route('admin.delete_staff', $member->id) }}">
                               Delete
                            </a>
                        </td>

                        <td>
                            <a class="btn btn-warning" href="{{ route('admin.update_staff', $member->id) }}">
                                Update
                            </a>
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
