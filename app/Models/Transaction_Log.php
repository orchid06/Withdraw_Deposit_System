<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction_Log extends Model
{
    use HasFactory;

    protected $table    = ['transactions'];
    protected $fillable = ['user_id', 'trx_code', 'amount' , 'trx_type'];

    protected $casts    = ['trx_type' => 'string'];


}
