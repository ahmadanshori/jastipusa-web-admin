<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CustomerPurchaseExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return Customer::all(); // Atau tambahkan query filter jika perlu
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama',
            'Email', 
            'Nomor WhatsApp',
            'Alamat',
            'Tanggal Bergabung',
        ];
    }

    public function map($customer): array
    {
        return [
            $customer->id,
            $customer->display_name,
            $customer->email_address,
            $customer->whatsapp_number,
            $customer->address,
            $customer->created_at->format('d/m/Y'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Header bold dan background abu-abu
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['rgb' => 'DDDDDD']
                ]
            ],
            // Auto size kolom
            'A:F' => ['autoSize' => true]
        ];
    }
}