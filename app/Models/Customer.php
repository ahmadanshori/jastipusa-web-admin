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
}