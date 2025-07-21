<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerOrder extends Model
{

    protected $table = "customer_order";

    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'no_hp_wa', 'rekening_name', 'link_product', 'jumlah_berat', 'id_whatsapp_number', 'po_number', 'status'
    ];
}