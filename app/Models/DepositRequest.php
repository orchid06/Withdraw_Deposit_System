<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositRequest extends Model
{
    use HasFactory;

    protected $table    = 'deposit_requests'; 
    protected $fillable = ['user_id' , 'deposit_method_id', 'amount', 'fields', 'status', 'feedback'];

    protected $cast     = [ 'status' => 'string'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function depositMethods()
    {
        return $this-> belongsTo(DepositMethod::class);
    }
}
