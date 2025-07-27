<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; }
        .invoice-container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { display: flex; justify-content: space-between; margin-bottom: 30px; }
        .logo { max-width: 150px; }
        .invoice-info { text-align: right; }
        .invoice-title { font-size: 24px; font-weight: bold; margin-bottom: 10px; }
        .section { margin-bottom: 20px; }
        .section-title { font-size: 16px; font-weight: bold; border-bottom: 1px solid #eee; padding-bottom: 5px; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background-color: #f5f5f5; text-align: left; padding: 8px; border: 1px solid #ddd; }
        td { padding: 8px; border: 1px solid #ddd; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .totals-table { width: 300px; margin-left: auto; }
        .footer { margin-top: 50px; font-size: 10px; text-align: center; color: #666; }
        .signature-area { margin-top: 50px; display: flex; justify-content: space-between; }
        .signature-box { width: 200px; border-top: 1px dashed #333; text-align: center; padding-top: 5px; }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header Section -->
        <div class="header">
            <div>
                <h1 class="invoice-title">INVOICE</h1>
                <p><strong>From:</strong> Your Company Name</p>
                <p>Your Company Address</p>
                <p>Phone: (123) 456-7890</p>
            </div>
            <div class="invoice-info">
                <p><strong>Invoice #:</strong> {{ $purchase->purchase_number }}</p>
                <p><strong>Date:</strong> {{ $date }}</p>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="section">
            <div class="section-title">Bill To</div>
            <table>
                <tr>
                    <td width="20%"><strong>Customer:</strong></td>
                    <td>{{ $customer->display_name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td><strong>Phone:</strong></td>
                    <td>{{ $purchase->no_telp ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td><strong>Email:</strong></td>
                    <td>{{ $customer->email ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td><strong>Address:</strong></td>
                    <td>{{ $customer->address ?? 'N/A' }}</td>
                </tr>
            </table>
        </div>

        <!-- Items Table -->
        <div class="section">
            <div class="section-title">Order Details</div>
            <table>
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">PO</th>
                        <th width="35%">Item Description</th>
                        <th width="15%" class="text-right">Weight (kg)</th>
                        <th width="15%" class="text-right">Unit Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($purchaseOrderDetail as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item->no_po }}</td>
                        <td>{{ $item->nama_barang }} {{ $item->link_barang }}</td>
                        <td class="text-right">{{ $item->estimasi_kg }}</td>
                        <td class="text-right">Rp {{ number_format($item->estimasi_harga, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Totals Section -->
        <div class="section">
            <table class="totals-table">
                <tr>
                    <td><strong>Subtotal:</strong></td>
                    <td class="text-right">Rp {{ number_format($purchaseOrderDetail->sum(function($item) {
                        return $item->estimasi_harga;
                    }), 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td><strong>Total Amount:</strong></td>
                    <td class="text-right">Rp {{ number_format($purchaseOrderDetail->sum(function($item) {
                        return  $item->estimasi_harga;
                    }), 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <!-- Payment Information -->
        <div class="section">
            <div class="section-title">Payment Information</div>
            <p>Bank Transfer: Bank Name</p>
            <p>Account Number: 1234 5678 9012</p>
            <p>Account Holder: Your Company Name</p>
        </div>

    
    </div>
</body>
</html>