<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    protected $table = "customer_chat_conversations";

    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'whatsapp_number', 'display_name', 'address', 'email_address'
    ];
    public function getMembershipDuration($full = false)
    {
        $createdAt = $this->created_at;
        $now = now();
        $diff = $createdAt->diff($now);
        
        if ($full) {
            $parts = [];
            if ($diff->y > 0) $parts[] = $diff->y . ' tahun';
            if ($diff->m > 0) $parts[] = $diff->m . ' bulan';
            if ($diff->d > 0) $parts[] = $diff->d . ' hari';
            
            return implode(', ', $parts) ?: 'Kurang dari 1 hari';
        }
        
        return $this->getSimpleDuration($diff);
    }

    protected function getSimpleDuration($diff)
    {
        if ($diff->y >= 1) return $diff->y . ' tahun';
        if ($diff->m >= 1) return $diff->m . ' bulan';
        if ($diff->d >= 7) return floor($diff->d / 7) . ' minggu';
        return $diff->d . ' hari';
    }

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class, 'no_telp', 'whatsapp_number');
    }
}