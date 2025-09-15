<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{

    protected $table = "brand";

    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'name', 'code'
    ];
  
}