<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawRequest extends Model
{
    use HasFactory;

    protected $table    = 'withdraw_requests'; 
    protected $fillable = ['user_id', 'withdraw_method_id', 'amount','fields', 'status', 'feedback'];

    protected $casts    = [ 'status' => 'string' ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function withdrawMethods()
    {
        return $this->belongsTo(WithdrawMethod::class);
    }
}
