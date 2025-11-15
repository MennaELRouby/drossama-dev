<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Security Scan Report</title>
    <style>
        body{font-family:sans-serif}
        table{border-collapse:collapse;width:100%}
        td,th{border:1px solid #f34a07;padding:8px}
        th{background:#ffffff}
    </style>
</head>
<body>
    <h1>PHP Security Scan Report</h1>
    @if(isset($message))
        <div style="background:#e0ffe0;color:#008000;padding:15px;margin-bottom:20px;border:1px solid #008000;text-align:center;font-weight:bold;">
            {{ $message }}
        </div>
    @endif
    @if(session('message'))
        <script>alert("{{ session('message') }}"); window.location.reload();</script>
    @endif
    <table>
        <thead>
            <tr>
                <th>File</th>
                <th>Line</th>
                <th>Function</th>
                <th>Code</th>
                <th>Action</th>
            </tr>
    </thead>
        <tbody>
            @foreach ($results as $r)
                <tr>
                    <td>{{ $r['file'] }}</td>
                    <td>{{ $r['line'] }}</td>
                    <td><strong>{{ $r['function'] }}</strong></td>
                    <td><code>{{ htmlentities($r['code']) }}</code></td>
                    <td>
                        <form method="POST" action="{{ url('dashboard/scan/delete-line') }}" style="display:inline" onsubmit="return confirm('هل أنت متأكد أنك تريد حذف هذا السطر؟');">
                            @csrf
                            <input type="hidden" name="file" value="{{ $r['file'] }}">
                            <input type="hidden" name="line" value="{{ $r['line'] }}">
                            <button type="submit" style="background:#f34a07;color:#fff;border:none;padding:5px 10px;cursor:pointer;">حذف السطر</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
