<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdraw_Request extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'withdraw_method_id', 'amount', 'status', 'feedback'];

    protected $casts    = [ 'status' => 'string' ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function withdraw_method()
    {
        return $this->belongsTo(Withdraw_Method::class);
    }
}
