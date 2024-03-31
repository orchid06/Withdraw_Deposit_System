<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionLog extends Model
{
    use HasFactory;

    protected $table    = 'transactions';
    protected $fillable = ['user_id', 'trx_code', 'amount', 'trx_type'];

    protected $casts    = ['trx_type' => 'string'];

    public static function destroyLog($userId, $trx_code)
    {
        self::where('user_id', $userId)
            ->where('trx_code', $trx_code)
            ->delete();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
