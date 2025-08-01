
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            border: none;
            padding: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #2c3e50;
            margin: 0;
        }
        .header h2 {
            color: #7f8c8d;
            margin: 5px 0 20px;
        }
        .invoice-info {
            margin-bottom: 20px;
        }
        .invoice-info table {
            width: 100%;
            border-collapse: collapse;
        }
        .invoice-info td {
            padding: 3px 0;
        }
        .customer-info {
            margin-bottom: 30px;
        }
        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .product-table th {
            background-color: #f2f2f2;
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        .product-table td {
            padding: 8px;
            border-bottom: 1px solid #eee;
        }
        .product-table tr:last-child td {
            border-bottom: 2px solid #ddd;
            font-weight: bold;
        }
        .summary-table {
            width: 300px;
            margin-left: auto;
            border-collapse: collapse;
        }
        .summary-table td {
            padding: 8px;
            border-bottom: 1px solid #eee;
        }
        .summary-table tr:last-child td {
            font-weight: bold;
            border-bottom: 2px solid #ddd;
        }
        .footer {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }
        .purchased-by {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="header">
            <h1>JASTIPUSA</h1>
            <h2>Invoice</h2>
        </div>
   
        <div class="invoice-info">
            <table>
                <tr>
                    <td>Invoice Number : {{$purchase->id}}</td>
                </tr>
                <tr>
                    <td>Date :  {{$purchase->created_at}}</td>
                </tr>
                <tr>
                    <td>Shipping :  {{$purchase->created_at}}</td>
                </tr>
            </table>
        </div>

        <div class="customer-info">
            <p><strong>Customer Information :</strong></p>
            <p>{{$purchase->nama}}</p>
            <p>{{$purchase->alamat}}</p>
            <p>{{$purchase->no_telp}}</p>
        </div>

        <table class="product-table">
        <thead>
            <tr>
                <th>Product</th>
                <th>QTY</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchaseOrderDetail as $item)
            <tr>
                <td>{{ $item->nama_barang }}</td>  <!-- Product Name -->
                <td>1</td>  <!-- Quantity (using estimasi_kg) -->
                <td>{{ number_format($item->estimasi_harga ?? 0, 0, ',', '.') }}</td>  
            </tr>
            @endforeach
            <tr>
                <td colspan="2"><strong>Total</strong></td>
                <td>{{ number_format($purchaseOrderDetail->sum('estimasi_harga') ?? 0, 0, ',', '.')  }}</td>  
            </tr>
        </tbody>
    </table>

        <div class="purchased-by">
            <p><strong>Purchased by :</strong></p>
            <p>{{$purchase->nama}} </p>
        </div>

        <table class="summary-table">
            <tr>
                <td>Subtotal</td>
                <td>{{ number_format($purchaseOrderDetail->sum('estimasi_harga') ?? 0, 0, ',', '.')  }}</td>
            </tr>
            <tr>
                <td>Diskon</td>
                <td>0</td>
            </tr>
            <tr>
                <td>PPN (0%)</td>
                <td>0</td>
            </tr>
            <tr>
                <td>Biaya Lain-lain</td>
                <td>0</td>
            </tr>
            <tr>
                <td>Total DP</td>
                <td>{{ number_format($purchaseOrderDetail->sum('dp') ?? 0, 0, ',', '.')  }}</td>
            </tr>
            <tr>
                <td>Total</td>
                <td>{{ number_format($purchaseOrderDetail->sum('estimasi_harga') - $purchaseOrderDetail->sum('dp') ?? 0, 0, ',', '.')  }}</td>
            </tr>
        </table>
    </div>
</body>
</html>