<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawMethod extends Model
{
    use HasFactory;

    protected $table    = 'withdraw_methods';
    protected $fillable = ['name', 'is_active', 'fields', 'min' , 'max'];
    protected $cast     = ['is_active' => 'boolean'];

    public function withdrawRequests()
    {
        return $this->hasMany(WithdrawRequest::class);
    }
}
