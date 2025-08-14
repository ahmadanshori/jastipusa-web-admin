<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderDetail extends Model
{

    protected $table = "purchase_order_detail";
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'integer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
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

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }
}