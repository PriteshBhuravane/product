<x-navbar />
<div class="container mt-4">
    <h2>Admin Logs</h2>
    <div>
        <div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Action</th>
                        <th>Details</th>
                        <th>Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                    <tr>
                        <td>{{ $log->id }}</td>
                        <td>{{ $log->action }}</td>
                        <td>{{ $log->details }}</td>
                        <td>{{ $log->created_at }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
