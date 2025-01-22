<!DOCTYPE html>
<html>
<head>
    <title>Slow Queries</title>
</head>
<body>
    <h1>Slow Queries</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Query</th>
                <th>Type</th>
                <th>Execution Time (ms)</th>
                <th>Executed At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($slowQueries as $query)
                <tr>
                    <td>{{ $query->query }}</td>
                    <td>{{ $query->type }}</td>
                    <td>{{ $query->execution_time }}</td>
                    <td>{{ $query->executed_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <form action="{{ route('slowQueryMonitor.clear') }}" method="DELETE">
        @csrf
        <button type="submit">Clear All</button>
    </form>
</body>
</html>