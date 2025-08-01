<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;

class PurchaseOrderExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'PurchaseOrder' => new PurchaseOrderSheet(),
            'PurchaseOrderDetail' => new PurchaseOrderDetailSheet()
        ];
    }
}

class PurchaseOrderSheet implements \Maatwebsite\Excel\Concerns\FromCollection, 
                                  \Maatwebsite\Excel\Concerns\WithHeadings,
                                  \Maatwebsite\Excel\Concerns\WithStyles
{
    public function collection()
    {
        return PurchaseOrder::select([
            'nama',
            'no_telp', 
            'alamat',
            'email',
            'status'
        ])->get();
    }

    public function headings(): array
    {
        return [
            'Nama Customer',
            'No Telepon',
            'Alamat',
            'Email',
            'Status'
        ];
    }

    public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            'A:E' => ['autoSize' => true]
        ];
    }
}

class PurchaseOrderDetailSheet implements \Maatwebsite\Excel\Concerns\FromCollection,
                                         \Maatwebsite\Excel\Concerns\WithHeadings
{
    public function collection()
    {
        return PurchaseOrderDetail::select([
            'no_po',
            'purchase_order_id',
            'nama_barang',
            'link_barang',
            'estimasi_kg',
            'estimasi_harga',
            'status_follow_up',
            'nama_rek_transfer',
            'jumlah_transfer',
            'dp',
            'fullpayment',
            'foto_bukti_tf',
            'mutasi_check',
            'payment_method',
            'total_purchase',
            'foto_bukti_pembelian',
            'status_purchase',
            'notes',
            'hpp_mutasi_check',
            'wh_usa',
            'status_on_check',
            'wh_indo',
            'fix_weight',
            'fix_price',
            'status_barang_sampai'
        ])->get();
    }

    public function headings(): array
    {
        return [
            'No PO',
            'Purchase Order ID',
            'Nama Barang',
            'Link Barang',
            'Estimasi Kg',
            'Estimasi Harga',
            'Status Follow Up',
            'Nama Rekening Transfer',
            'Jumlah Transfer',
            'DP',
            'Full Payment',
            'Foto Bukti TF',
            'Mutasi Check',
            'Payment Method',
            'Total Purchase',
            'Foto Bukti Pembelian',
            'Status Purchase',
            'Notes',
            'HPP Mutasi Check',
            'WH USA',
            'Status On Check',
            'WH Indo',
            'Fix Weight',
            'Fix Price',
            'Status Barang Sampai'
        ];
    }
}