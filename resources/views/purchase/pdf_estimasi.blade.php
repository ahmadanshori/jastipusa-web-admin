<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice - Jastipusa</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            color: #333;
            background: #fff;
        }
        .container {
            width: 100%;
            margin: auto;
        }
        .header {
            border-bottom: 2px solid #ccc;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }
        .header-table {
            width: 100%;
        }
        .header-table td {
            vertical-align: middle;
        }
        .logo {
            width: 180px;
            height: auto;
        }
        .header-title {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            background: #81011f;
            color: #fff;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 5px;
            vertical-align: top;
        }
        .info-table .invoice-info {
            text-align: right;
        }
        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 12px;
        }
        .product-table th, .product-table td {
            border: 1px solid #ccc;
            padding: 8px;
        }
        .product-table th {
            background-color: #f1f1f1;
        }
        .summary-table {
            width: 40%;
            margin-left: auto;
            border-collapse: collapse;
        }
        .summary-table td {
            padding: 5px;
        }
        .summary-table .label {
            font-weight: bold;
        }
        .currency {
            text-align: right;
            font-family: monospace;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
        .notes {
            font-style: italic;
            font-size: 11px;
            margin-top: 5px;
            color: #555;
        }
    </style>
</head>
<body>
<div class="container">

    <!-- Header -->
    <div class="header">
        <table class="header-table">
            <tr>
                <td>
                     <img src="data:image/jpeg;base64,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" alt="Logo" srcset="" style="max-width: 100%; height: auto;">
                </td>
                <td class="header-title">
                    PURCHASE ORDER
                </td>
            </tr>
        </table>
    </div>

    <!-- Info -->
    <table class="info-table">
            <tr>
                <td width="50%">
                    <strong>Kepada:</strong><br>
                    {{$purchase->nama}}<br>
                    {{$purchase->no_telp}}<br>
                    {{$purchase->alamat}}
                </td>
                <td width="50%" class="invoice-info">
                    <strong>No. Invoice:</strong> {{$purchase->no_invoice}}<br>
                    <strong>Tanggal:</strong> {{ $purchase->created_at->format('d F Y') }}<br>
                    <strong>Pengiriman:</strong> {{ $purchase->updated_at->format('d F Y') }}
                </td>
            </tr>
        </table>

    <!-- Produk -->
    <table class="product-table">
         <thead>
            <tr>
                <th>Product</th>
                <th>Notes</th>
                <th>QTY</th>
                <th>Weight (KG)</th>
                <th>Price (IDR)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchaseOrderDetail as $item)
            <tr>
                <td>{{ $item->nama_barang }}</td>  <!-- Product Name -->
                <td>{{ $item->estimasi_notes }}</td>  <!-- Product Name -->
                <td>{{ $item->qty }}</td>  <!-- Quantity (using estimasi_kg) -->
                <td>{{ $item->qty }}</td>  <!-- Quantity (using estimasi_kg) -->
                <td>{{ number_format($item->estimasi_harga ?? 0, 0, ',', '.') }}</td>  
            </tr>
            @endforeach
            <tr>
                <td colspan="4"><strong>Total</strong></td>
                <td>{{ number_format($purchaseOrderDetail->sum('estimasi_harga') ?? 0, 0, ',', '.')  }}</td>  
            </tr>
        </tbody>
    </table>

    <!-- Summary -->
    <table class="summary-table">
         {{-- <tr>
                <td>Subtotal</td>
                <td>{{ number_format($purchaseOrderDetail->sum('estimasi_harga') ?? 0, 0, ',', '.')  }}</td>
            </tr> --}}
            <tr>
                <td>Diskon</td>
                <td>{{ $purchaseOrderDetail->sum('estimasi_diskon') }}</td>
            </tr>
            <tr>
                <td>Asuransi (2%)</td>
                <td>{{ $purchaseOrderDetail->sum('asuransi') }}</td>
            </tr>
            <tr>
                <td>PPN (0%)</td>
                <td>0</td>
            </tr>
            <tr>
                <td>Biaya Jasa/Kg (0%)</td>
                <td>{{ $purchaseOrderDetail->sum('jasa') }}</td>
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
                <td>{{ number_format($purchaseOrderDetail->sum('estimasi_harga') - $purchaseOrderDetail->sum('estimasi_diskon') + $purchaseOrderDetail->sum('asuransi')  + $purchaseOrderDetail->sum('jasa') - $purchaseOrderDetail->sum('dp') ?? 0, 0, ',', '.')  }}</td>
            </tr>
    </table>

    <table>
            <tr>
                <td><b>Notes</b></td>
            </tr>
            <tr>
                <td><b>Requested By :</b></td>
                <td>{{ $user->name }}</td>
                <td>({{ $role->name }})</td>
            </tr>
            <tr>
                <td>{{ $purchaseOrderDetail[0]->nama_rek_transfer }}</td>
            </tr>
           
    </table>

    
</div>
</body>
</html>
