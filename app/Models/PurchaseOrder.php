<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{

    protected $table = "purchase_order";
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'integer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'no_telp',
        'alamat',
        'email',
        'status',
        'no_invoice',
        'tipe_order',
    ];

   
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    
    public function purchaseOrderDetails()
    {
        return $this->hasMany(PurchaseOrderDetail::class);
    }

     protected static function boot()
    {
        parent::boot();

        // Auto generate invoice number sebelum create
        static::creating(function ($model) {
            if (empty($model->no_invoice)) {
                $model->no_invoice = $model->generatePurchaseOrderNumber($model->tipe_order);
            }
        });
    }

   public function generatePurchaseOrderNumber(string $orderType): string
    {
        // Validasi tipe order
        $validOrderTypes = ['01', '02', '03', '04'];
        if (!in_array($orderType, $validOrderTypes)) {
            throw new \Exception("Tipe order tidak valid. Gunakan: 01, 02, 03, atau 04");
        }

        // Prefix tetap
        $prefix = "JUSA";
        
        // Tahun dan bulan sekarang
        $year = now()->format('Y');
        $month = now()->format('m');
        
        // Pattern untuk mencari invoice terakhir bulan ini
        $pattern = $prefix . $year . $month . $orderType . '%';
        
        // Cari invoice terakhir dengan pattern yang sama
        $lastInvoice = self::where('no_invoice', 'like', $pattern)
            ->orderBy('no_invoice', 'desc')
            ->first();
        
        // Tentukan increment number
        if ($lastInvoice && $lastInvoice->no_invoice) {
            $lastNumber = substr($lastInvoice->no_invoice, -4);
            $increment = intval($lastNumber) + 1;
        } else {
            $increment = 1;
        }
        
        // Format increment menjadi 4 digit
        $incrementFormatted = str_pad($increment, 4, '0', STR_PAD_LEFT);
        
        // Gabungkan semua bagian
        return $prefix . $year . $month . $orderType . $incrementFormatted;
    }
    
    /**
     * Get order type name
     *
     * @param string $orderTypeCode
     * @return string
     */
    public function getOrderTypeName(string $orderTypeCode): string
    {
        $types = [
            '01' => 'Jasmin',
            '02' => 'Jastip Order',
            '03' => 'Jastip Only',
            '04' => 'Jastip B2B'
        ];
        
        return $types[$orderTypeCode] ?? 'Unknown';
    }

    /**
     * Accessor untuk nama tipe order
     */
    public function getOrderTypeNameAttribute()
    {
        return $this->getOrderTypeName($this->tipe_order);
    }
}