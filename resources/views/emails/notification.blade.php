<!DOCTYPE html>
<html>
<head>
    <title>Notif Email</title>
</head>
<body>
    
    <p>Ada data order baru:</p>
    <ul>
        <li>No Po: {{ $data->no_invoice }}</li>
        <li>Customer: {{ $data->nama }}</li>
        <li>Alamat: {{ $data->alamat }}</li>
    </ul>

    <p>Data ini ditambahkan atau di update oleh {{ $data->user }} ({{$data->role}})</p>
    
    <footer>
        <p>&copy; {{ date('Y') }}. All rights reserved.</p>
    </footer>
</body>
</html>