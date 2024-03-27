<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawMethod extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'parameter', 'min', 'max'];

    public function withdrawRequests()
    {
        return $this->hasMany(WithdrawRequest::class);
    }
}
